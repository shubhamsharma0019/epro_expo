<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EproExpo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <main class="mx-auto max-w-6xl p-8">
        <header class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#1E1B4B]">Exhibition Management Panel</h1>
                <p class="mt-1 text-sm text-gray-500">Welcome, Administrator. Oversee slot purchases, booth approvals, and event publish approvals.</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm hover:bg-gray-50">
                    Log Out
                </button>
            </form>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            <!-- Card 1: Booth Bookings -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-gradient-to-br from-[#4F46E5] to-[#3D1B9B] p-6 text-white">
                    <div class="flex items-center justify-between">
                        <i class="fa-solid fa-receipt text-3xl opacity-80"></i>
                        <span class="rounded bg-white/20 px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide">Flow Stage 1</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-bold flex items-center gap-3">
                        Booth Bookings Review
                        @if(isset($pendingBookingsCount) && $pendingBookingsCount > 0)
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white shadow-sm">{{ $pendingBookingsCount }}</span>
                        @endif
                    </h2>
                    <p class="mt-2 text-sm text-white/80">Manage paid booth purchase requests. Approve payments and slot selections before exhibitors can build their profile.</p>
                </div>
                <div class="p-6">
                    <a href="{{ route('admin.booth-bookings.index') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] py-3 text-sm font-bold text-white hover:bg-[#2F1480]">
                        Go to Booth Bookings &rarr;
                    </a>
                </div>
            </div>

            <!-- Card 2: Booth Profile Approvals -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-gradient-to-br from-[#7C3AED] to-[#5B2EFF] p-6 text-white">
                    <div class="flex items-center justify-between">
                        <i class="fa-solid fa-store text-3xl opacity-80"></i>
                        <span class="rounded bg-white/20 px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide">Flow Stage 2</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-bold flex items-center gap-3">
                        Booth Publish Approvals
                        @if(isset($pendingApprovalsCount) && $pendingApprovalsCount > 0)
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white shadow-sm">{{ $pendingApprovalsCount }}</span>
                        @endif
                    </h2>
                    <p class="mt-2 text-sm text-white/80">Verify setup contents (catalogues, documents, media, team) completed by approved exhibitors before publishing them live.</p>
                </div>
                <div class="p-6">
                    <a href="{{ route('admin.booth-approvals.index') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-[#3D1B9B] py-3 text-sm font-bold text-white hover:bg-[#2F1480]">
                        Go to Publish Approvals &rarr;
                    </a>
                </div>
            </div>

            <!-- Card 3: Event Approvals -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="bg-gradient-to-br from-[#0F766E] to-[#115E59] p-6 text-white">
                    <div class="flex items-center justify-between">
                        <i class="fa-solid fa-calendar-check text-3xl opacity-80"></i>
                        <span class="rounded bg-white/20 px-2.5 py-0.5 text-xs font-bold uppercase tracking-wide">Event Flow</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-bold flex items-center gap-3">
                        Event Publish Approvals
                        @if(isset($pendingEventApprovalsCount) && $pendingEventApprovalsCount > 0)
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white shadow-sm">{{ $pendingEventApprovalsCount }}</span>
                        @endif
                    </h2>
                    <p class="mt-2 text-sm text-white/80">Approve submitted company events before they appear on the event dashboard and public event website.</p>
                </div>
                <div class="p-6">
                    <a href="{{ route('admin.event-approvals.index') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-[#115E59] py-3 text-sm font-bold text-white hover:bg-[#0F4F4B]">
                        Go to Event Approvals &rarr;
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
