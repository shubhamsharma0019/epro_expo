@props([
    'variant' => 'desktop',
    'label' => 'Get Started',
    'bookBoothLabel' => 'Book a Booth',
    'bookBoothUrl' => null,
    'createEventLabel' => 'Create Company Event',
    'createEventUrl' => null,
    'menuId' => 'getStartedMenu',
])

@php
    $bookBoothUrl = $bookBoothUrl ?: route('company.home');
    $createEventUrl = $createEventUrl ?: route('company.event-company.login');
    $linkClass = 'group inline-flex items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-5 py-3.5 text-[14px] font-bold text-navy shadow-sm transition-all duration-200 hover:border-transparent hover:bg-gradient-to-r hover:from-[#6D28D9] hover:to-[#4B16D8] hover:text-white hover:shadow-[0_14px_30px_rgba(91,46,255,0.28)]';
@endphp

@if ($variant === 'mobile')
    <div class="grid grid-cols-1 gap-3 pt-2 min-[420px]:grid-cols-2">
        <a href="{{ $bookBoothUrl }}" class="{{ $linkClass }}">
            <i class="fas fa-store text-lg text-[#FF9B41] transition-colors group-hover:text-white"></i>
            {{ $bookBoothLabel }}
        </a>
        <a href="{{ $createEventUrl }}" class="{{ $linkClass }}">
            <i class="fas fa-calendar-plus text-lg text-[#6D28D9] transition-colors group-hover:text-white"></i>
            {{ $createEventLabel }}
        </a>
    </div>
@else
    <div class="relative" data-get-started-root="{{ $menuId }}">
        <button
            type="button"
            data-get-started-toggle="{{ $menuId }}"
            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-3 text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.26)]"
            aria-expanded="false"
            aria-haspopup="true"
        >
            {{ $label }}
            <i class="fas fa-chevron-down text-[11px] opacity-90 transition-transform duration-200" data-get-started-chevron="{{ $menuId }}"></i>
        </button>

        <div
            data-get-started-panel="{{ $menuId }}"
            class="absolute right-0 z-50 mt-2.5 hidden min-w-[420px] rounded-2xl border border-[#E7EAF3] bg-white p-3 shadow-[0_16px_40px_rgba(7,16,68,0.12)]"
        >
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ $bookBoothUrl }}" class="{{ $linkClass }} px-4 py-4 text-[13px] sm:text-[14px]">
                    <i class="fas fa-store text-lg text-[#FF9B41] transition-colors group-hover:text-white"></i>
                    {{ $bookBoothLabel }}
                </a>
                <a href="{{ $createEventUrl }}" class="{{ $linkClass }} px-4 py-4 text-[13px] sm:text-[14px]">
                    <i class="fas fa-calendar-plus text-lg text-[#6D28D9] transition-colors group-hover:text-white"></i>
                    {{ $createEventLabel }}
                </a>
            </div>
        </div>
    </div>

    @once
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-get-started-root]').forEach((root) => {
                    const menuId = root.getAttribute('data-get-started-root');
                    const toggle = root.querySelector(`[data-get-started-toggle="${menuId}"]`);
                    const panel = root.querySelector(`[data-get-started-panel="${menuId}"]`);
                    const chevron = root.querySelector(`[data-get-started-chevron="${menuId}"]`);

                    if (!toggle || !panel) {
                        return;
                    }

                    const close = () => {
                        panel.classList.add('hidden');
                        toggle.setAttribute('aria-expanded', 'false');
                        chevron?.classList.remove('rotate-180');
                    };

                    toggle.addEventListener('click', (event) => {
                        event.stopPropagation();
                        const isOpen = !panel.classList.contains('hidden');
                        document.querySelectorAll('[data-get-started-panel]').forEach((otherPanel) => {
                            otherPanel.classList.add('hidden');
                        });
                        document.querySelectorAll('[data-get-started-toggle]').forEach((otherToggle) => {
                            otherToggle.setAttribute('aria-expanded', 'false');
                        });
                        document.querySelectorAll('[data-get-started-chevron]').forEach((otherChevron) => {
                            otherChevron.classList.remove('rotate-180');
                        });

                        if (isOpen) {
                            close();
                            return;
                        }

                        panel.classList.remove('hidden');
                        toggle.setAttribute('aria-expanded', 'true');
                        chevron?.classList.add('rotate-180');
                    });

                    panel.querySelectorAll('a').forEach((link) => {
                        link.addEventListener('click', close);
                    });

                    document.addEventListener('click', (event) => {
                        if (!root.contains(event.target)) {
                            close();
                        }
                    });
                });
            });
        </script>
    @endonce
@endif
