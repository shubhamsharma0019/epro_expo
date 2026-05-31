<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Approvals</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <main class="mx-auto max-w-6xl p-8">
        <h1 class="mb-2 text-3xl font-bold text-[#1E1B4B]">Event Approvals</h1>
        <p class="mb-6 text-sm text-gray-500">Review submitted company events and publish approved events live.</p>

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif

        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="min-w-[760px]">
                <div class="grid grid-cols-5 gap-4 border-b border-gray-100 bg-gray-50 px-5 py-3 text-xs font-bold uppercase tracking-wide text-gray-500">
                    <span>Event</span>
                    <span>Company</span>
                    <span>Tickets</span>
                    <span>Status</span>
                    <span class="text-right">Action</span>
                </div>
                @forelse ($publishRequests as $request)
                    <a href="{{ route('admin.event-approvals.show', $request) }}" class="grid grid-cols-5 gap-4 border-b border-gray-100 p-5 last:border-b-0 hover:bg-[#FBFAFF]">
                        <span class="font-bold">{{ $request->companyEvent?->title ?? 'Event' }}</span>
                        <span>{{ $request->company?->company_name ?? 'Company' }}</span>
                        <span>{{ $request->companyEvent?->ticketTypes?->count() ?? 0 }}</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $request->status)) }}</span>
                        <span class="text-right font-bold text-[#3D1B9B]">Review</span>
                    </a>
                @empty
                    <div class="p-8 text-gray-500">No event approval requests yet.</div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>
