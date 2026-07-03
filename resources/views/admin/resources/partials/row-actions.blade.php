@php
    $wrapClass = ($variant ?? 'mobile') === 'desktop'
        ? 'admin-action-row admin-action-row--desktop justify-end'
        : 'admin-action-row';
@endphp

<div class="{{ $wrapClass }}">
    @foreach ($actions as $action)
        @php
            $variant = $action['variant'] ?? '';
            $postClass = match ($variant) {
                'danger' => 'border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100',
                'success' => 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100',
                default => 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100',
            };
            $linkClass = 'border-[#E6E1FF] bg-[#F4F2FF] text-[#3723db] hover:bg-[#ebe6ff]';
        @endphp

        @if (($action['method'] ?? 'GET') === 'POST')
            <form method="POST" action="{{ $action['href'] }}" class="m-0">
                @csrf
                <button
                    type="submit"
                    class="inline-flex h-9 w-full items-center justify-center rounded-lg border px-3 text-[12px] font-semibold whitespace-nowrap transition {{ $postClass }}"
                >
                    {{ $action['label'] }}
                </button>
            </form>
        @else
            <a
                href="{{ $action['href'] }}"
                class="inline-flex h-9 w-full items-center justify-center rounded-lg border px-3 text-[12px] font-semibold whitespace-nowrap transition {{ $linkClass }}"
            >
                {{ $action['label'] }}
            </a>
        @endif
    @endforeach
</div>
