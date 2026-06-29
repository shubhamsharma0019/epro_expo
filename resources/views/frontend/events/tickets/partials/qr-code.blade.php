@php
    use App\Support\EventTicketQr;

    $displaySize = $displaySize ?? 220;
    $renderSize = max($displaySize * 2, 512);
    $verificationUrl = $verificationUrl
        ?? (isset($ticket) && $ticket instanceof \App\Domain\Visitor\Models\Ticket
            ? EventTicketQr::scannableUrlForTicket($ticket)
            : EventTicketQr::payload($visitorTicket ?? $ticket));
    $qrSvg = EventTicketQr::generateSvg($verificationUrl, $renderSize);
@endphp
<div
    class="inline-flex items-center justify-center rounded-xl border border-[#E7EAF3] bg-white p-2"
    style="width: {{ $displaySize }}px; height: {{ $displaySize }}px;"
    role="img"
    aria-label="Event ticket QR code"
>
    <div class="h-full w-full [&>svg]:block [&>svg]:h-full [&>svg]:w-full">
        {!! $qrSvg !!}
    </div>
</div>
