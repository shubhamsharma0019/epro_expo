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
        if (! function_exists('socket_create')) {
            return null;
        }

        try {
            $socket = @socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

            if ($socket === false) {
                return null;
            }

            @socket_connect($socket, '8.8.8.8', 53);
            @socket_getsockname($socket, $address);
            @socket_close($socket);

            if (
                ! empty($address)
                && ! self::isLoopbackHost($address)
                && filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
            ) {
                return $address;
            }
        } catch (\Throwable) {
            // ignore
        }

        return null;
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

    private static function isLoopbackHost(string $host): bool
    {
        return in_array(strtolower($host), ['127.0.0.1', 'localhost', '::1'], true);
    }
}
