<?php

namespace App\Domain\Shared\Services;

use App\Domain\Visitor\Models\Visitor;

class ExhibitionTicketConfirmedPageData
{
    /** @return array<string, mixed>|null */
    public function build(string $slug): ?array
    {
        $context = ExhibitionTicketFlowContext::resolve($slug);
        if (! $context) {
            return null;
        }

        $exhibition = $context['exhibition'];
        $title = $context['title'];
        $dateStr = $context['dateStr'];
        $location = $context['location'];

        $bookingId = request()->query('booking_id') ?: session('selected_visitor_booking_id');
        $visitor = null;

        if ($bookingId) {
            $visitor = Visitor::query()
                ->where('booking_id', $bookingId)
                ->where('exhibition_id', $exhibition->id)
                ->first();
        }

        if ($visitor) {
            session([
                'selected_visitor_booking_id' => $visitor->booking_id,
                'visitor_pass_active' => $visitor->payment_status === 'completed',
            ]);
        }

        $calendarStart = $exhibition->start_date ? $exhibition->start_date->format('Ymd') : null;
        $calendarEnd = $exhibition->end_date
            ? $exhibition->end_date->copy()->addDay()->format('Ymd')
            : $calendarStart;

        $calendarUrl = $calendarStart
            ? 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' . urlencode($title) . '&dates=' . $calendarStart . '/' . $calendarEnd . '&location=' . urlencode($location)
            : '#';

        $eTicketUrl = route('exhibitions.tickets.e-ticket', $slug);
        $dashboardUrl = route('exhibitions.visitor.dashboard', $slug);
        $confirmedUrl = route('exhibitions.tickets.confirmed', $slug);
        $exhibitionShowUrl = route('exhibitions.show', $slug);

        if ($visitor) {
            $eTicketUrl .= '?booking_id=' . urlencode($visitor->booking_id) . '&id=' . $exhibition->id;
        }

        $resolvedBookingId = $visitor?->booking_id ?: $bookingId;
        $qrCodeUrl = $resolvedBookingId
            ? 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($resolvedBookingId)
            : null;

        $emailCopy = $visitor?->email
            ? 'Your e-ticket and event details have been sent to ' . $visitor->email . '.'
            : 'Your e-ticket and event details have been sent.';

        return array_merge($context, [
            'visitor' => $visitor,
            'bookingId' => $resolvedBookingId,
            'showVisitorSidebar' => false,
            'eTicketUrl' => $eTicketUrl,
            'dashboardUrl' => $dashboardUrl,
            'confirmedUrl' => $confirmedUrl,
            'exhibitionShowUrl' => $exhibitionShowUrl,
            'calendarUrl' => $calendarUrl,
            'qrCodeUrl' => $qrCodeUrl,
            'nextSteps' => [
                [
                    'title' => 'Check Your Email',
                    'description' => $emailCopy,
                    'description_id' => 'next-email-copy',
                    'icon' => 'ph ph-envelope',
                    'icon_wrap_class' => 'bg-green-50 text-green-600 border-green-100',
                    'url' => null,
                    'target' => null,
                ],
                [
                    'title' => 'View E-Ticket',
                    'description' => 'Access your e-ticket and QR code.',
                    'description_id' => null,
                    'icon' => 'ph ph-ticket',
                    'icon_wrap_class' => 'bg-primary-50 text-primary-500 border-primary-100',
                    'url' => $eTicketUrl,
                    'target' => null,
                ],
                [
                    'title' => 'Add to Calendar',
                    'description' => $calendarStart ? 'Save ' . $dateStr . ' to your calendar.' : 'Event dates will be available soon.',
                    'description_id' => null,
                    'icon' => 'ph ph-calendar-plus',
                    'icon_wrap_class' => 'bg-blue-50 text-blue-500 border-blue-100',
                    'url' => $calendarUrl,
                    'target' => '_blank',
                ],
                [
                    'title' => 'Plan Your Visit',
                    'description' => 'Explore agenda, speakers and venue details for ' . $location . '.',
                    'description_id' => null,
                    'icon' => 'ph ph-map-pin',
                    'icon_wrap_class' => 'bg-orange-50 text-orange-500 border-orange-100',
                    'url' => $exhibitionShowUrl,
                    'target' => null,
                ],
            ],
            'actionButtons' => [
                [
                    'label' => 'Go to Dashboard',
                    'icon' => 'ph ph-monitor',
                    'url' => $dashboardUrl,
                    'class' => 'inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary-600 px-8 py-3 text-[15px] font-bold text-white shadow-[0_4px_14px_rgba(90,50,250,0.25)] transition-all hover:bg-primary-700 sm:w-auto',
                    'type' => 'link',
                ],
                [
                    'label' => 'View E-Ticket',
                    'icon' => 'ph ph-ticket',
                    'url' => $eTicketUrl,
                    'class' => 'inline-flex w-full items-center justify-center gap-2 rounded-xl border border-primary-200 bg-white px-8 py-3 text-[15px] font-bold text-primary-600 shadow-sm transition-all hover:bg-primary-50 sm:w-auto',
                    'type' => 'link',
                ],
                [
                    'label' => 'Share Registration',
                    'icon' => 'ph ph-export',
                    'url' => null,
                    'class' => 'inline-flex w-full items-center justify-center gap-2 rounded-xl border border-primary-200 bg-white px-8 py-3 text-[15px] font-bold text-primary-600 shadow-sm transition-all hover:bg-primary-50 sm:w-auto',
                    'type' => 'button',
                    'id' => 'share-registration-btn',
                ],
            ],
        ]);
    }
}
