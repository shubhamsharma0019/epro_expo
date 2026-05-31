@php
    $carouselId = 'event-hero-slider-' . uniqid();
    $heroSlides = [
        ['image' => 'event-hero-tech.png', 'alt' => 'Technology event hero'],
        ['image' => 'event-hero-ai.png', 'alt' => 'AI conference hero'],
        ['image' => 'event-hero-education.png', 'alt' => 'Education summit hero'],
    ];
@endphp

<div class="relative h-full overflow-hidden rounded-[18px] bg-[#060a28] shadow-[0_20px_45px_rgba(7,16,68,0.22)]">
    <div id="{{ $carouselId }}" class="flex h-full snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-5 py-5 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        @foreach ($heroSlides as $slide)
            <div class="h-full min-w-full snap-center overflow-hidden rounded-[16px] border border-white/10 bg-[#0b1237] shadow-[0_18px_36px_rgba(0,0,0,0.18)]">
                <img src="{{ asset('images/events-home/hero-slider/' . $slide['image']) }}" alt="{{ $slide['alt'] }}" class="block h-full w-full object-cover">
            </div>
        @endforeach
    </div>

    <button type="button" data-carousel-prev="{{ $carouselId }}" class="absolute left-4 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full bg-white/92 text-[#4C10D0] shadow-[0_10px_24px_rgba(7,16,68,0.22)] transition hover:bg-white" aria-label="Previous slide">
        <span class="text-[24px] leading-none">&lsaquo;</span>
    </button>
    <button type="button" data-carousel-next="{{ $carouselId }}" class="absolute right-4 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full bg-white/92 text-[#4C10D0] shadow-[0_10px_24px_rgba(7,16,68,0.22)] transition hover:bg-white" aria-label="Next slide">
        <span class="text-[24px] leading-none">&rsaquo;</span>
    </button>
</div>

<script>
    (() => {
        const carouselId = @json($carouselId);
        const slider = document.getElementById(carouselId);
        if (! slider) return;

        const scrollSlide = (direction) => {
            slider.scrollBy({ left: direction * slider.clientWidth, behavior: 'smooth' });
        };

        const nextSlide = () => {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 8) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
                return;
            }

            scrollSlide(1);
        };

        document.querySelectorAll(`[data-carousel-prev="${carouselId}"]`).forEach((button) => {
            button.addEventListener('click', () => scrollSlide(-1));
        });

        document.querySelectorAll(`[data-carousel-next="${carouselId}"]`).forEach((button) => {
            button.addEventListener('click', nextSlide);
        });

        let autoSlide = window.setInterval(nextSlide, 3200);

        slider.addEventListener('mouseenter', () => window.clearInterval(autoSlide));
        slider.addEventListener('mouseleave', () => {
            autoSlide = window.setInterval(nextSlide, 3200);
        });
    })();
</script>
