<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Ticket Confirmation</title>
</head>
<body style="font-family: Inter, Arial, sans-serif; background:#f8fafc; color:#0f172a; padding:24px;">
@php
    $event = $ticket->companyEvent;
    $eventName = $event?->title ?? $ticket->ticket_name ?? 'Event';
    $dateInfo = $event?->starts_at?->format('M d, Y') ?? 'Date TBD';
    $venue = \App\Support\LiveContent::formatCompanyEventVenue($event);
@endphp
<table width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;">
    <tr>
        <td style="padding:28px 32px;background:linear-gradient(135deg,#4318FF,#5B35D5);color:#ffffff;">
            <h1 style="margin:0;font-size:24px;">Booking Confirmed</h1>
            <p style="margin:8px 0 0;font-size:15px;opacity:0.9;">{{ $eventName }}</p>
        </td>
    </tr>
    <tr>
        <td style="padding:28px 32px;">
            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;">Hi {{ $ticket->attendee_name ?: $ticket->user?->name }},</p>
            <p style="margin:0 0 20px;font-size:15px;line-height:1.6;">Your visitor pass is confirmed. Present the QR code below at entry.</p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                <tr><td style="padding:8px 0;font-size:14px;color:#64748b;">Order Number</td><td style="padding:8px 0;font-size:14px;font-weight:700;text-align:right;">{{ $ticket->order_number }}</td></tr>
                @if ($issuedTicket ?? null)
                    <tr><td style="padding:8px 0;font-size:14px;color:#64748b;">Ticket Number</td><td style="padding:8px 0;font-size:14px;font-weight:700;text-align:right;">{{ $issuedTicket->ticket_no }}</td></tr>
                @endif
                <tr><td style="padding:8px 0;font-size:14px;color:#64748b;">Date</td><td style="padding:8px 0;font-size:14px;font-weight:700;text-align:right;">{{ $dateInfo }}</td></tr>
                <tr><td style="padding:8px 0;font-size:14px;color:#64748b;">Venue</td><td style="padding:8px 0;font-size:14px;font-weight:700;text-align:right;">{{ $venue }}</td></tr>
                <tr><td style="padding:8px 0;font-size:14px;color:#64748b;">Ticket Type</td><td style="padding:8px 0;font-size:14px;font-weight:700;text-align:right;">{{ $ticket->ticket_name }} × {{ $ticket->quantity }}</td></tr>
            </table>

            <div style="text-align:center;margin:24px 0;">
                {!! $qrEmailHtml !!}
                <p style="margin:12px 0 0;font-size:12px;color:#64748b;word-break:break-all;">Scan URL: {{ $verificationUrl }}</p>
            </div>

            <p style="margin:0 0 16px;text-align:center;">
                <a href="{{ $qrTicketUrl }}" style="display:inline-block;padding:12px 20px;background:#4318FF;color:#ffffff;text-decoration:none;border-radius:8px;font-size:14px;font-weight:700;">View QR Ticket</a>
            </p>

            <p style="margin:0;font-size:13px;color:#64748b;line-height:1.6;">Keep this email handy. You can also view and download your ticket from your visitor dashboard.</p>
        </td>
    </tr>
</table>
</body>
</html>
