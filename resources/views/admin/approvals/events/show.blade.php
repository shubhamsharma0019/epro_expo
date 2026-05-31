<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    @php
        $event = $publishRequest->companyEvent;
        $location = $event
            ? ($event->venue_name ?: trim(($event->city ?: '') . ($event->country ? ', ' . $event->country : '')) ?: 'Location TBD')
            : 'Location TBD';
    @endphp

    <main class="mx-auto max-w-5xl p-8">
        <a href="{{ route('admin.event-approvals.index') }}" class="mb-6 inline-flex text-sm font-bold text-[#3D1B9B]">Back to approvals</a>

        <div class="rounded-xl border border-gray-100 bg-white p-8 shadow-sm">
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="mb-2 text-3xl font-bold text-[#1E1B4B]">{{ $event?->title ?? 'Review Event' }}</h1>
                    <p class="text-gray-500">{{ $publishRequest->company?->company_name ?? 'Company' }} | {{ $location }}</p>
                </div>
                <span class="rounded-full bg-[#F4F1FF] px-4 py-2 text-sm font-bold text-[#4C10D0]">{{ ucfirst(str_replace('_', ' ', $publishRequest->status)) }}</span>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
            @endif

            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-xs font-bold uppercase text-gray-500">Dates</div>
                    <div class="mt-2 text-sm font-semibold text-gray-900">{{ $event?->starts_at?->format('M d, Y') ?? 'Date TBD' }}</div>
                </div>
                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-xs font-bold uppercase text-gray-500">Category</div>
                    <div class="mt-2 text-sm font-semibold text-gray-900">{{ $event?->category ?? 'Category TBD' }}</div>
                </div>
                <div class="rounded-lg bg-gray-50 p-4">
                    <div class="text-xs font-bold uppercase text-gray-500">Ticket Types</div>
                    <div class="mt-2 text-sm font-semibold text-gray-900">{{ $event?->ticketTypes?->count() ?? 0 }}</div>
                </div>
            </div>

            <div class="mb-6 rounded-lg border border-gray-100 p-5">
                <h2 class="mb-2 text-base font-bold text-[#1E1B4B]">Summary</h2>
                <p class="text-sm leading-6 text-gray-600">{{ $event?->summary ?: 'No summary provided.' }}</p>
            </div>

            <div class="flex flex-col gap-4 md:flex-row">
                <form method="POST" action="{{ route('admin.event-approvals.approve', $publishRequest) }}">
                    @csrf
                    <button class="w-full rounded-lg bg-[#3D1B9B] px-6 py-3 text-sm font-bold text-white md:w-auto">Approve & Publish</button>
                </form>
                <form method="POST" action="{{ route('admin.event-approvals.reject', $publishRequest) }}" class="flex flex-1 flex-col gap-3 md:flex-row">
                    @csrf
                    <input name="review_notes" required placeholder="Reason for rejection" class="flex-1 rounded-lg border border-gray-200 px-4 py-3 text-sm">
                    <button class="rounded-lg border border-red-200 px-6 py-3 text-sm font-bold text-red-600">Reject</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
