<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booth Approvals</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <main class="mx-auto max-w-6xl p-8">
        <h1 class="mb-6 text-3xl font-bold text-[#1E1B4B]">Booth Approvals</h1>
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
        @endif
        <div class="overflow-x-auto rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="min-w-[600px]">
                @forelse ($publishRequests as $request)
                    <a href="{{ route('admin.booth-approvals.show', $request) }}" class="grid grid-cols-4 gap-4 border-b border-gray-100 p-5 last:border-b-0 hover:bg-[#FBFAFF]">
                        <span class="font-bold">{{ $request->boothBooking->company->company_name ?? 'Company' }}</span>
                        <span>{{ $request->boothBooking->booth->booth_number ?? 'Booth' }}</span>
                        <span>{{ ucfirst($request->status) }}</span>
                        <span class="text-right text-[#3D1B9B] font-bold">Review</span>
                    </a>
                @empty
                    <div class="p-8 text-gray-500">No booth approval requests yet.</div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>
