@extends('layouts.frontend')

@section('title', 'Exhibitor Booths - EproExpo')

@section('content')
@php
    $boothCards = ($booths ?? collect())->filter(fn ($booking) => filled($booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name));
@endphp
<section class="bg-[#FBFAFF] px-5 py-8 sm:px-8 lg:px-10">
    <div class="mx-auto max-w-[1500px]">
        <div class="rounded-[20px] border border-[#E7EAF3] bg-white p-6 shadow-[0_14px_34px_rgba(7,16,68,0.07)] lg:p-8">
            <p class="text-[13px] font-bold uppercase tracking-[0.12em] text-[#5b2eff]">Company directory</p>
            <h1 class="mt-3 text-[34px] font-bold text-[#071044]">Booths / Companies</h1>
            <p class="mt-3 max-w-[820px] text-[15px] font-medium leading-7 text-[#5A6480]">Visit booths to see products, documents, catalogues, media galleries, business cards and enquiry forms. If a booth interests you, open it, scan details, enquire, or continue exploring the next company.</p>
            <div class="mt-6 flex flex-col gap-3 lg:flex-row">
                <input type="text" placeholder="Search companies, products, categories" class="h-12 min-w-0 flex-1 rounded-lg border border-[#E7EAF3] px-4 text-[14px] outline-none focus:border-[#5b2eff]">
                <button class="h-12 rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-6 text-[14px] font-bold text-white">Search</button>
            </div>
            <div class="mt-5 flex flex-wrap gap-2">
                @foreach (['All booths', 'Live demo', 'Documents available', 'Meeting slots', 'Saved'] as $filter)
                    <button class="rounded-full border border-[#E7EAF3] bg-[#FBFAFF] px-4 py-2 text-[12px] font-bold text-[#34405F] hover:border-[#5b2eff] hover:bg-[#F4F0FF] hover:text-[#5b2eff]">{{ $filter }}</button>
                @endforeach
            </div>
        </div>

        @if ($boothCards->isEmpty())
            <div class="mt-7 rounded-[16px] border border-[#E7EAF3] bg-white p-10 text-center shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                <p class="text-[18px] font-bold text-[#071044]">No published booths yet</p>
                <p class="mt-3 text-[14px] font-medium leading-6 text-[#5A6480]">Approved and published exhibitor booths will appear here once companies complete booth setup.</p>
            </div>
        @else
            <div class="mt-7 grid gap-5 md:grid-cols-3">
                @foreach ($boothCards as $booking)
                    @php
                        $company = $booking->boothProfile?->company_name ?: $booking->company?->company_name ?: $booking->company?->name;
                        $companySlug = \Illuminate\Support\Str::slug($company);
                        $copy = $booking->boothProfile?->tagline ?: $booking->boothProfile?->about_company ?: 'Visit this booth to explore company products, documents, catalogues and meeting options.';
                        $location = collect([$booking->pavilion?->title, $booking->hall?->title])->filter()->implode(' / ') ?: 'Exhibition booth';
                    @endphp
                    <article class="rounded-[16px] border border-[#E7EAF3] bg-white p-6 shadow-[0_8px_22px_rgba(7,16,68,0.05)]">
                        <div class="flex items-start gap-4">
                            <div class="grid h-14 w-14 shrink-0 place-items-center rounded-xl bg-[#F4F0FF] text-[20px] font-bold text-[#5b2eff]">{{ substr($company, 0, 1) }}</div>
                            <div class="min-w-0">
                                <h2 class="text-[20px] font-bold text-[#071044]">{{ $company }}</h2>
                                <p class="mt-1 text-[12px] font-bold text-[#5b2eff]">{{ $location }}</p>
                            </div>
                        </div>
                        <p class="mt-4 line-clamp-3 text-[14px] font-medium leading-6 text-[#5A6480]">{{ $copy }}</p>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-lg bg-[#FBFAFF] p-3 text-[12px] font-bold text-[#34405F]">{{ $booking->published_products_count ?? 0 }} Products</div>
                            <div class="rounded-lg bg-[#FBFAFF] p-3 text-[12px] font-bold text-[#34405F]">{{ $booking->public_catalogues_count ?? 0 }} Catalogues</div>
                        </div>
                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('exhibitions.booths.show', [$slug, $companySlug]) }}" class="inline-flex h-10 flex-1 items-center justify-center rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-4 text-[13px] font-bold text-white">Visit Booth</a>
                            <button class="inline-flex h-10 items-center justify-center rounded-lg border border-[#E7EAF3] px-4 text-[13px] font-bold text-[#071044] hover:bg-[#F4F0FF]">Save</button>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
