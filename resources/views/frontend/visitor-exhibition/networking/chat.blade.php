@extends('layouts.exhibition')

@section('title', 'Live Chat - EproExpo')

@section('content')
@include('frontend.visitor-exhibition.shared.flow-styles')

<section class="visitor-flow-page max-w-[1200px] px-5 py-8 sm:px-8 lg:px-10 lg:py-10">
    <div class="grid overflow-hidden rounded-xl border border-borderColor bg-white shadow-sm lg:grid-cols-[330px_minmax(0,1fr)]">
        <aside class="border-b border-borderColor bg-[#FBFAFF] p-6 lg:border-b-0 lg:border-r">
            <p class="text-[13px] font-semibold uppercase tracking-[0.12em] text-purple">Live chat</p>
            <h1 class="mt-3 text-[28px] font-semibold tracking-[-0.6px] text-navy">{{ $companyName ?? 'Exhibitor' }}</h1>
            <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">Ask about products, demos, brochures and meeting availability.</p>
            @if (!empty($companySlug))
                <a href="{{ route('exhibitions.visitor.companies.show', [$slug, $companySlug]) }}" class="mt-6 inline-flex h-11 items-center justify-center rounded-md border border-borderColor bg-white px-5 text-[13px] font-semibold text-purple">Open Booth</a>
            @endif
        </aside>

        <div class="p-6">
            @if (session('success'))
                <p class="mb-4 rounded-lg bg-[#EEFDF3] px-4 py-3 text-[14px] font-semibold text-[#16A34A]">{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-[14px] font-semibold text-red-700">{{ session('error') }}</p>
            @endif

            <div class="min-h-[280px] space-y-4">
                @forelse (($messages ?? collect()) as $message)
                    @if ($message->sender_type === 'visitor')
                        <div class="ml-auto max-w-[76%] rounded-xl bg-[#5b2eff] p-4 text-[14px] font-medium leading-6 text-white">{{ $message->message }}</div>
                    @else
                        <div class="max-w-[76%] rounded-xl bg-[#F4F0FF] p-4 text-[14px] font-medium leading-6 text-navy">{{ $message->message }}</div>
                    @endif
                @empty
                    <div class="visitor-flow-empty">
                        <p class="text-[15px] font-semibold text-navy">Start the conversation</p>
                        <p class="mt-2 text-[14px] text-[#5A6480]">Your messages are saved to the exhibition database for this booth.</p>
                    </div>
                @endforelse
            </div>

            @if (!empty($companySlug))
                <form method="POST" action="{{ route('exhibitions.visitor.chat.send', [$slug, $companySlug]) }}" class="mt-6 flex gap-3">
                    @csrf
                    <input type="text" name="message" required placeholder="Type your message..." class="h-12 min-w-0 flex-1 rounded-md border border-borderColor px-4 text-[14px] font-medium outline-none focus:border-purple">
                    <button type="submit" class="h-12 rounded-md bg-[#5b2eff] px-6 text-[14px] font-semibold text-white">Send</button>
                </form>
            @endif
        </div>
    </div>
</section>
@endsection
