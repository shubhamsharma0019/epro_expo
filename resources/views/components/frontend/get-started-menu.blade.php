@props([
    'variant' => 'desktop',
    'label' => 'Get Started',
    'bookBoothLabel' => 'Book a Booth',
    'bookBoothUrl' => null,
    'createEventLabel' => 'Create Company Event',
    'createEventUrl' => null,
    'visitorLoginLabel' => 'Log In',
    'visitorLoginUrl' => null,
    'visitorRegisterLabel' => 'Sign Up',
    'visitorRegisterUrl' => null,
    'menuId' => 'getStartedMenu',
])

@php
    $bookBoothUrl = $bookBoothUrl ?: route('company.home');
    $createEventUrl = $createEventUrl ?: route('company.event-company.login');
    $visitorLoginUrl = $visitorLoginUrl ?: route('frontend.user.login');
    $visitorRegisterUrl = $visitorRegisterUrl ?: route('frontend.user.register');
    $mobileLinkClass = 'group inline-flex items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-5 py-3.5 text-[14px] font-bold text-navy shadow-sm transition-all duration-200 hover:border-transparent hover:bg-gradient-to-r hover:from-[#6D28D9] hover:to-[#4B16D8] hover:text-white hover:shadow-[0_14px_30px_rgba(91,46,255,0.28)]';
@endphp

@once
    @include('components.frontend.partials.get-started-menu-styles')
@endonce

@if ($variant === 'mobile')
    <div class="grid grid-cols-1 gap-3 pt-2 min-[420px]:grid-cols-2">
        <a href="{{ $bookBoothUrl }}" class="{{ $mobileLinkClass }}">
            <i class="fas fa-store text-lg text-[#FF9B41] transition-colors group-hover:text-white"></i>
            {{ $bookBoothLabel }}
        </a>
        <a href="{{ $createEventUrl }}" class="{{ $mobileLinkClass }}">
            <i class="fas fa-calendar-plus text-lg text-[#6D28D9] transition-colors group-hover:text-white"></i>
            {{ $createEventLabel }}
        </a>
        @guest
            <a href="{{ $visitorLoginUrl }}" class="{{ $mobileLinkClass }}">
                <i class="fas fa-right-to-bracket text-lg text-[#2563EB] transition-colors group-hover:text-white"></i>
                {{ $visitorLoginLabel }}
            </a>
            <a href="{{ $visitorRegisterUrl }}" class="{{ $mobileLinkClass }}">
                <i class="fas fa-user-plus text-lg text-[#6D28D9] transition-colors group-hover:text-white"></i>
                {{ $visitorRegisterLabel }}
            </a>
        @else
            <a href="{{ route('frontend.user.dashboard') }}" class="{{ $mobileLinkClass }} min-[420px]:col-span-2">
                <i class="fas fa-gauge text-lg text-[#2563EB] transition-colors group-hover:text-white"></i>
                My Dashboard
            </a>
        @endguest
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
            class="hidden"
        >
            <div class="gs-menu-grid">
                <a href="{{ $bookBoothUrl }}" class="gs-menu-link">
                    <i class="fas fa-store text-[#FF9B41]"></i>
                    {{ $bookBoothLabel }}
                </a>
                <a href="{{ $createEventUrl }}" class="gs-menu-link">
                    <i class="fas fa-calendar-plus text-[#6D28D9]"></i>
                    {{ $createEventLabel }}
                </a>
                @guest
                    <a href="{{ $visitorLoginUrl }}" class="gs-menu-link">
                        <i class="fas fa-right-to-bracket text-[#2563EB]"></i>
                        {{ $visitorLoginLabel }}
                    </a>
                    <a href="{{ $visitorRegisterUrl }}" class="gs-menu-link">
                        <i class="fas fa-user-plus text-[#6D28D9]"></i>
                        {{ $visitorRegisterLabel }}
                    </a>
                @else
                    <a href="{{ route('frontend.user.dashboard') }}" class="gs-menu-link gs-menu-link--wide">
                        <i class="fas fa-gauge text-[#2563EB]"></i>
                        My Dashboard
                    </a>
                @endguest
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
