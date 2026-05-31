<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Booth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <main class="mx-auto max-w-4xl p-8">
        <a href="{{ route('admin.booth-approvals.index') }}" class="mb-6 inline-flex text-sm font-bold text-[#3D1B9B]">Back to approvals</a>
        <div class="rounded-xl border border-gray-100 bg-white p-8 shadow-sm">
            <h1 class="mb-2 text-3xl font-bold text-[#1E1B4B]">Review Booth</h1>
            <p class="mb-6 text-gray-500">{{ $publishRequest->boothBooking->company->company_name ?? 'Company' }} | Booth {{ $publishRequest->boothBooking->booth->booth_number ?? '--' }}</p>
            @if (session('status'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">{{ session('status') }}</div>
            @endif
            <div class="mb-6 rounded-lg bg-gray-50 p-4 text-sm">
                Status: <strong>{{ ucfirst($publishRequest->status) }}</strong>
            </div>
            <div class="flex gap-4">
                <form method="POST" action="{{ route('admin.booth-approvals.approve', $publishRequest) }}">
                    @csrf
                    <button class="rounded-lg bg-[#3D1B9B] px-6 py-3 text-sm font-bold text-white">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.booth-approvals.reject', $publishRequest) }}" class="flex flex-1 gap-3">
                    @csrf
                    <input name="rejection_reason" required placeholder="Rejection reason" class="flex-1 rounded-lg border border-gray-200 px-4 py-3 text-sm">
                    <button class="rounded-lg border border-red-200 px-6 py-3 text-sm font-bold text-red-600">Reject</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
