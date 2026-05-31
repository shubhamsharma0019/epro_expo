<div class="mb-8 flex gap-3 overflow-x-auto rounded-xl border border-borderColor bg-white p-2 shadow-sm">
    @foreach ([
        ['Profile', '/exhibitions/exhibitors/booth-profile'],
        ['Products', '/exhibitions/exhibitors/products'],
        ['Documents', '/exhibitions/exhibitors/documents'],
        ['Catalogues', '/exhibitions/exhibitors/catalogues'],
        ['Gallery', '/exhibitions/exhibitors/media-gallery'],
        ['Meetings', '/exhibitions/exhibitors/meetings'],
        ['Enquiries', '/exhibitions/exhibitors/enquiries'],
    ] as [$label, $href])
        <a href="{{ url($href) }}"
            class="shrink-0 rounded-md px-4 py-2.5 text-[14px] font-semibold {{ request()->is(ltrim($href, '/')) ? 'bg-[#F4F0FF] text-purple' : 'text-[#34405F] hover:bg-[#F4F0FF] hover:text-purple' }}">
            {{ $label }}
        </a>
    @endforeach
</div>
