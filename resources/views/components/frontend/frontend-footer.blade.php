<footer class="border-t border-[#E7EAF3] bg-white">
    <div class="mx-auto max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10">
        <div class="grid gap-10 lg:grid-cols-[1.35fr_.8fr_.8fr_1fr] xl:gap-14">
            <div class="min-w-0">
                <x-shared.frontend-brand-logo size="footer" />

                <p class="mt-5 max-w-[410px] text-[15px] font-medium leading-7 text-[#5A6480]">
                    A modern exhibition and event management platform for discovering pavilions, booking booths, adding services, and managing exhibitor profiles.
                </p>
            </div>

            <div>
                <h3 class="text-[15px] font-extrabold text-[#071044]">Explore</h3>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('events.home') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Explore Events</a>
                    <a href="{{ route('exhibitions.pavilions.index') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Pavilions</a>
                    <a href="{{ route('exhibitions.halls.index') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Halls</a>
                    <a href="{{ route('exhibitions.booths.sizes') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Booths</a>
                </div>
            </div>

            <div>
                <h3 class="text-[15px] font-extrabold text-[#071044]">Platform</h3>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('exhibitions.booking.summary') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Booking Summary</a>
                    <a href="{{ route('exhibitions.booking.services') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Services</a>
                    <a href="{{ route('exhibitions.booking.my-bookings') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">My Bookings</a>
                    <a href="{{ route('exhibitions.exhibitors.booth-profile') }}" class="block text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Exhibitor Profile</a>
                </div>
            </div>

            <div>
                <h3 class="text-[15px] font-extrabold text-[#071044]">Contact</h3>
                <div class="mt-4 space-y-3">
                    <p class="text-[14px] font-medium text-[#5A6480]">support@eproexpo.com</p>
                    <p class="text-[14px] font-medium text-[#5A6480]">+91 98765 43210</p>
                    <p class="text-[14px] font-medium leading-6 text-[#5A6480]">Virtual Exhibition Desk,<br>New Delhi, India</p>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-4 border-t border-[#E7EAF3] pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-[14px] font-medium text-[#5A6480]">&copy; {{ date('Y') }} EproExpo. All rights reserved.</p>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('home') }}" class="text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Privacy Policy</a>
                <a href="{{ route('home') }}" class="text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Terms</a>
                <a href="{{ route('home') }}" class="text-[14px] font-medium text-[#5A6480] transition hover:text-[#5b2eff]">Cookies</a>
            </div>
        </div>
    </div>
</footer>
