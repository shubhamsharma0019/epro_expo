<form action="{{ route('events.listings.index') }}" class="grid gap-4 pt-5 sm:grid-cols-2 lg:grid-cols-[1.55fr_1.08fr_1.08fr_1fr_auto]">
    <label class="block">
        <span class="text-[13px] font-semibold">Search Events</span>
        <span class="mt-2 flex h-12 items-center gap-3 rounded-lg border border-[#E7EAF3] px-4 text-[#8B91A7]">
            <span class="text-[18px] text-[#8B91A7]">&#9906;</span>
            <input name="search" class="min-w-0 flex-1 border-0 bg-transparent text-[14px] outline-none placeholder:text-[#8B91A7]" placeholder="Event name, speaker, topic...">
        </span>
    </label>
    <label class="block">
        <span class="text-[13px] font-semibold">Category</span>
        <select name="category" class="mt-2 h-12 w-full rounded-lg border border-[#E7EAF3] bg-white px-4 text-[14px] font-medium outline-none">
            <option value="">All Categories</option>
            @foreach (($categories ?? []) as $category)
                @php
                    $categoryName = is_array($category) ? ($category['name'] ?? '') : $category;
                    $categoryValue = is_array($category) ? ($category['value'] ?? $categoryName) : $category;
                @endphp
                @if ($categoryName)
                    <option value="{{ $categoryValue }}">{{ $categoryName }}</option>
                @endif
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-[13px] font-semibold">Country</span>
        <select name="country" class="mt-2 h-12 w-full rounded-lg border border-[#E7EAF3] bg-white px-4 text-[14px] font-medium outline-none">
            <option value="">All Countries</option>
            @foreach (($countries ?? []) as $country)
                @php
                    $countryName = is_array($country) ? ($country['name'] ?? '') : $country;
                @endphp
                @if ($countryName)
                    <option value="{{ $countryName }}">{{ $countryName }}</option>
                @endif
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-[13px] font-semibold">Date</span>
        <input type="date" name="date" class="mt-2 h-12 w-full rounded-lg border border-[#E7EAF3] px-4 text-[14px] font-medium outline-none">
    </label>
    <button class="mt-auto h-12 rounded-lg bg-gradient-to-r from-[#5b2eff] to-[#4310d8] px-8 text-[14px] font-semibold text-white shadow-[0_8px_18px_rgba(91,46,255,0.25)] sm:col-span-2 lg:col-span-1">Search Events</button>
</form>
