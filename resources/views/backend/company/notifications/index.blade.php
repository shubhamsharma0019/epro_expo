@extends(request()->query('flow') === 'event' ? 'layouts.company-event' : 'layouts.company')

@section('title', 'Notifications | eproexpo')
@section('page-title', 'Notifications')

@section('content')
<section class="mx-auto w-full max-w-[1100px] px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-[28px] font-bold leading-tight text-gray-900 sm:text-[34px]">Notifications</h1>
        <p class="mt-2 text-[15px] font-medium leading-7 text-gray-500">Recent enquiries and meeting requests for your company.</p>
    </div>

    <div class="rounded-xl sm:rounded-2xl border border-gray-100 bg-white shadow-sm">
        @forelse ($notifications as $notification)
            <div class="flex gap-3 sm:gap-4 border-b border-gray-100 p-4 sm:p-5 last:border-b-0">
                <span class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-lg sm:rounded-xl bg-[#F4F0FF] text-[#3b18ff]">
                    <i class="{{ $notification['icon'] }} text-lg sm:text-xl"></i>
                </span>
                <div class="min-w-0 flex-1">
                    <h2 class="text-[14px] sm:text-[15px] font-bold text-gray-900 leading-tight">{{ $notification['title'] }}</h2>
                    <p class="mt-1 text-[13px] sm:text-[14px] font-medium leading-normal text-gray-500">{{ $notification['message'] }}</p>
                    <p class="mt-2 text-[11px] sm:text-[12px] font-semibold text-gray-400">{{ $notification['time']->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <div class="px-5 py-12 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#F4F0FF] text-[#3b18ff]">
                    <i class="ph ph-bell-simple text-2xl"></i>
                </div>
                <h2 class="mt-4 text-[17px] font-bold text-gray-900">No notifications yet</h2>
                <p class="mt-2 text-[14px] font-medium text-gray-500">New enquiries and meeting requests will appear here.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection
