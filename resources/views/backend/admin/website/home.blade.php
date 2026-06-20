@extends('layouts.admin')

@section('title', 'Website Home Content')
@section('page-title', 'Website Home')

@section('content')
    <section class="px-5 py-6 sm:px-8">
        <div class="mx-auto max-w-5xl space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-[28px] font-bold text-[#0B132C]">Website Home Page</h2>
                <p class="mt-2 text-[14px] text-gray-500">Manage hero, CTA, footer, and featured live content. Published changes appear on the public home page immediately.</p>
            </div>

            @if (session('status'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-[14px] font-medium text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-[14px] font-medium text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.website.home.update') }}" class="space-y-6">
                @csrf

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Hero / Banner</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">Headline line 1</label>
                            <input type="text" name="hero_title_line_1" value="{{ old('hero_title_line_1', $hero['title_line_1']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">Headline line 2</label>
                            <input type="text" name="hero_title_line_2" value="{{ old('hero_title_line_2', $hero['title_line_2']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">Highlighted phrase</label>
                            <input type="text" name="hero_title_highlight" value="{{ old('hero_title_highlight', $hero['title_highlight']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">Hero image URL</label>
                            <input type="text" name="hero_image_url" value="{{ old('hero_image_url', $hero['image_url']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]">
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-[13px] font-semibold">Subtitle</label>
                            <textarea name="hero_subtitle" rows="3" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-[14px]">{{ old('hero_subtitle', $hero['subtitle']) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">CTA Section</h3>
                    <div class="mt-5 grid gap-4">
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">CTA title</label>
                            <input type="text" name="cta_title" value="{{ old('cta_title', $cta['title']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]" required>
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">CTA subtitle</label>
                            <textarea name="cta_subtitle" rows="2" class="w-full rounded-xl border border-gray-200 px-4 py-3 text-[14px]">{{ old('cta_subtitle', $cta['subtitle']) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Footer & Contact</h3>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-2 block text-[13px] font-semibold">Copyright text</label>
                            <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $footer['copyright']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]">
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">Contact email</label>
                            <input type="email" name="footer_contact_email" value="{{ old('footer_contact_email', $footer['contact_email']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]">
                        </div>
                        <div>
                            <label class="mb-2 block text-[13px] font-semibold">Contact phone</label>
                            <input type="text" name="footer_contact_phone" value="{{ old('footer_contact_phone', $footer['contact_phone']) }}" class="h-11 w-full rounded-xl border border-gray-200 px-4 text-[14px]">
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <h3 class="text-[18px] font-bold text-[#0B132C]">Statistics</h3>
                        <label class="inline-flex items-center gap-2 text-[13px] font-semibold text-gray-600">
                            <input type="checkbox" name="use_live_stats" value="1" class="rounded border-gray-300" @checked($useLiveStats)>
                            Use live database counts (events, exhibitions, companies, booths)
                        </label>
                    </div>
                    <p class="mt-2 text-[13px] text-gray-500">When enabled, the home page shows real counts from approved/published content.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Featured Exhibitions</h3>
                    <p class="mt-1 text-[13px] text-gray-500">Only published, approved exhibitions appear on the website.</p>
                    <div class="mt-4 max-h-48 space-y-2 overflow-y-auto">
                        @forelse ($exhibitions as $exhibition)
                            <label class="flex items-center gap-3 rounded-lg border border-gray-100 px-3 py-2 text-[14px]">
                                <input type="checkbox" name="featured_exhibitions[]" value="{{ $exhibition->id }}" @checked(in_array($exhibition->id, $featuredExhibitionIds, true))>
                                <span>{{ $exhibition->title ?: $exhibition->name }}</span>
                            </label>
                        @empty
                            <p class="text-[13px] text-gray-500">No live exhibitions yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Featured Events</h3>
                    <div class="mt-4 max-h-48 space-y-2 overflow-y-auto">
                        @forelse ($events as $event)
                            <label class="flex items-center gap-3 rounded-lg border border-gray-100 px-3 py-2 text-[14px]">
                                <input type="checkbox" name="featured_events[]" value="{{ $event->id }}" @checked(in_array($event->id, $featuredEventIds, true))>
                                <span>{{ $event->title }}</span>
                            </label>
                        @empty
                            <p class="text-[13px] text-gray-500">No published events yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-[18px] font-bold text-[#0B132C]">Featured Companies / Exhibitors</h3>
                    <div class="mt-4 max-h-48 space-y-2 overflow-y-auto">
                        @forelse ($companies as $company)
                            <label class="flex items-center gap-3 rounded-lg border border-gray-100 px-3 py-2 text-[14px]">
                                <input type="checkbox" name="featured_companies[]" value="{{ $company->id }}" @checked(in_array($company->id, $featuredCompanyIds, true))>
                                <span>{{ $company->company_name ?: $company->name }}</span>
                            </label>
                        @empty
                            <p class="text-[13px] text-gray-500">No approved companies yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-xl bg-[#3723db] px-6 py-3 text-[14px] font-bold text-white hover:bg-[#2b1bb8]">
                        Save & Publish to Website
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
