<?php

namespace App\Support;

use App\Domain\Visitor\Models\Ticket;
use App\Domain\Visitor\Models\VisitorTicket;
use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class EventTicketQr
{
    public static function verificationUrl(string $qrToken): string
    {
        return self::scannableUrlForToken($qrToken);
    }

    public static function scannableUrlForToken(string $qrToken): string
    {
        $path = route('verify-ticket.show', ['qr_token' => $qrToken], false);

        $baseUrl = self::resolveScannableBaseUrl();

        return rtrim($baseUrl, '/') . $path;
    }

    public static function scannableUrlForTicket(Ticket $ticket): string
    {
        return self::scannableUrlForToken($ticket->qr_token);
    }

    public static function payload(VisitorTicket $ticket): string
    {
        $issuedTicket = EventTicketSchema::isReady()
            ? Ticket::query()
                ->whereHas('booking', fn ($query) => $query->where('visitor_ticket_id', $ticket->id))
                ->first()
            : null;

        if ($issuedTicket) {
            return self::scannableUrlForTicket($issuedTicket);
        }

        if (filled($ticket->qr_code_path) && str_starts_with($ticket->qr_code_path, 'http')) {
            return $ticket->qr_code_path;
        }

        return json_encode([
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->company_event_id,
            'visitor_id' => $ticket->user_id,
            'booking_code' => $ticket->order_number,
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function generateSvg(string $content, int $size = 512): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size, 2),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        return $writer->writeString(
            $content,
            Encoder::DEFAULT_BYTE_MODE_ENCODING,
            ErrorCorrectionLevel::H()
        );
    }

    public static function generateEmailHtml(string $content, int $pixelSize = 6): string
    {
        $encoded = Encoder::encode($content, ErrorCorrectionLevel::H());
        $matrix = $encoded->getMatrix();
        $width = $matrix->getWidth();
        $html = '<table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;border-collapse:collapse;">';

        for ($y = 0; $y < $width; $y++) {
            $html .= '<tr>';

            for ($x = 0; $x < $width; $x++) {
                $color = $matrix->get($x, $y) === 1 ? '#000000' : '#ffffff';
                $html .= sprintf(
                    '<td style="width:%1$dpx;height:%1$dpx;background-color:%2$s;padding:0;margin:0;line-height:0;font-size:0;"></td>',
                    $pixelSize,
                    $color
                );
            }

            $html .= '</tr>';
        }

        $html .= '</table>';

        return $html;
    }

    public static function appBaseUrl(): string
    {
        return self::resolveScannableBaseUrl();
    }

    public static function absoluteUrl(string $path, array $parameters = []): string
    {
        $relative = route($path, $parameters, false);

        return rtrim(self::appBaseUrl(), '/') . $relative;
    }

    public static function imageUrlForToken(string $qrToken, int $size = 512): string
    {
        return url(route('ticket-qr.image', [
            'qr_token' => $qrToken,
            'size' => $size,
        ], false));
    }

    public static function imageUrl(VisitorTicket $ticket, int $size = 512): string
    {
        if (EventTicketSchema::isReady()) {
            $issuedTicket = Ticket::query()
                ->whereHas('booking', fn ($query) => $query->where('visitor_ticket_id', $ticket->id))
                ->first();

            if ($issuedTicket) {
                return self::imageUrlForToken($issuedTicket->qr_token, $size);
            }
        }

        return self::svgDataUri(self::payload($ticket), $size);
    }

    public static function imageUrlForTicket(Ticket $ticket, int $size = 512): string
    {
        return self::imageUrlForToken($ticket->qr_token, $size);
    }

    public static function svgDataUri(string $content, int $size = 512): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode(self::generateSvg($content, $size));
    }

    public static function resolveContentForToken(string $qrToken): ?string
    {
        if (! EventTicketSchema::isReady()) {
            return null;
        }

        $ticket = Ticket::query()->where('qr_token', $qrToken)->first();

        return $ticket ? self::scannableUrlForTicket($ticket) : null;
    }

    private static function resolveScannableBaseUrl(): string
    {
        $configured = config('app.ticket_qr_base_url');

        if (filled($configured)) {
            return rtrim((string) $configured, '/');
        }

        if (! app()->runningInConsole() && request()->hasHeader('Host')) {
            $host = request()->getHost();

            if (! self::isLoopbackHost($host)) {
                return request()->getSchemeAndHttpHost();
            }
        }

        $appUrl = (string) config('app.url');
        $host = parse_url($appUrl, PHP_URL_HOST) ?: '';

        if ($host !== '' && ! self::isLoopbackHost($host) && ! self::isTunnelHost($host)) {
            return rtrim($appUrl, '/');
        }

        if (app()->environment('local')) {
            $lanBase = self::resolveLocalNetworkBaseUrl();

            if ($lanBase !== null) {
                return $lanBase;
            }
        }

        if (! app()->runningInConsole() && request()->hasHeader('Host')) {
            return request()->getSchemeAndHttpHost();
        }

        return rtrim($appUrl, '/');
    }

    private static function isTunnelHost(string $host): bool
    {
        $host = strtolower($host);
        $tunnelDomains = [
            'loca.lt',
            'ngrok.io',
            'ngrok-free.app',
            'ngrok.app',
            'trycloudflare.com',
            'localtunnel.me',
        ];

        foreach ($tunnelDomains as $domain) {
            if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                return true;
            }
        }

        return false;
    }

    private static function resolveLocalNetworkBaseUrl(): ?string
    {
        return self::detectLocalNetworkBaseUrl();
    }

    public static function detectLocalNetworkBaseUrl(): ?string
    {
        $port = self::resolveLocalServePort();
        $lanIp = self::detectLanIp();

        if ($lanIp === null) {
            return null;
        }

        return "http://{$lanIp}:{$port}";
    }

    private static function resolveLocalServePort(): int
    {
        if (! app()->runningInConsole() && request()->hasHeader('Host')) {
            $port = request()->getPort();

            if ($port) {
                return (int) $port;
            }
        }

        $appPort = parse_url((string) config('app.url'), PHP_URL_PORT);

        return $appPort ? (int) $appPort : 8000;
    }

    private static function detectLanIp(): ?string
    {
        $preferred = [];

        foreach (self::collectLanIpCandidates() as $ip) {
            if (
                filled($ip)
                && ! self::isLoopbackHost($ip)
                && ! str_starts_with($ip, '169.254.')
                && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
            ) {
                $preferred[] = $ip;
            }
        }

        $preferred = array_values(array_unique($preferred));

        foreach ($preferred as $ip) {
            if (str_starts_with($ip, '192.168.')) {
                return $ip;
            }
        }

        foreach ($preferred as $ip) {
            if (str_starts_with($ip, '10.')) {
                return $ip;
            }
        }

        return $preferred[0] ?? null;
    }

    private static function collectLanIpCandidates(): array
    {
        $candidates = [];

        if (PHP_OS_FAMILY === 'Windows') {
            $output = @shell_exec('ipconfig');

            if (is_string($output) && preg_match_all('/IPv4 Address[^:]*:\s*(\d+\.\d+\.\d+\.\d+)/i', $output, $matches)) {
                foreach ($matches[1] as $ip) {
                    $candidates[] = $ip;
                }
            }
        }

        if (function_exists('socket_create')) {
            try {
                $socket = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

                if ($socket !== false) {
                    @socket_connect($socket, '8.8.8.8', 53);
                    @socket_getsockname($socket, $address);
                    @socket_close($socket);

                    if (filled($address ?? null)) {
                        $candidates[] = $address;
                    }
                }
            } catch (\Throwable) {
                // ignore
            }
        }

        if (function_exists('gethostname')) {
            $hostname = gethostname();

            if ($hostname) {
                $resolved = gethostbyname($hostname);

                if ($resolved && $resolved !== $hostname) {
                    $candidates[] = $resolved;
                }
            }
        }

        return $candidates;
    }

    public static function refreshStoredUrl(Ticket $ticket): string
    {
        $url = self::scannableUrlForTicket($ticket);

        $ticket->update(['qr_url' => $url]);

        $visitorTicket = $ticket->booking?->visitorTicket;

        if ($visitorTicket) {
            $visitorTicket->update(['qr_code_path' => $url]);
        }

        return $url;
    }

    public static function usesLoopbackUrl(?string $url): bool
    {
        if (! filled($url)) {
            return true;
        }

        $host = parse_url($url, PHP_URL_HOST);

        return ! $host || self::isLoopbackHost((string) $host);
    }

    public static function mobileScanHint(?string $url): ?string
    {
        if (! app()->environment('local') || ! self::usesLoopbackUrl($url)) {
            return null;
        }

        $lanIp = self::detectLanIp();
        $port = self::resolveLocalServePort();

        if ($lanIp) {
            return "To scan from your phone, start the server with `php artisan serve --host=0.0.0.0 --port={$port}`, then open http://{$lanIp}:{$port} on your phone and sign in to the scanner.";
        }

        return 'To scan from your phone, set TICKET_QR_BASE_URL=http://YOUR-LAN-IP:8000 in .env and start the server with `php artisan serve --host=0.0.0.0`.';
    }

    private static function isLoopbackHost(string $host): bool
    {
        return in_array(strtolower($host), ['127.0.0.1', 'localhost', '::1'], true);
    }
}
