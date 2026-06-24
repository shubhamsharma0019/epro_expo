@php
    $home = $home ?? [];
    $hero = $home['hero'] ?? \App\Support\WebsiteContent::defaultHero();
    $stats = $home['stats'] ?? [];
    $experienceTabs = $home['experience_tabs'] ?? [];
    $featurePills = $home['feature_pills'] ?? \App\Support\WebsiteContent::defaultFeaturePills();
    $features = $home['features'] ?? \App\Support\WebsiteContent::defaultFeatures();
    $steps = $home['steps'] ?? \App\Support\WebsiteContent::defaultSteps();
    $boothHighlight = $home['booth_highlight'] ?? [];
    $partners = $home['partners'] ?? \App\Support\WebsiteContent::defaultPartners();
    $cta = $home['cta'] ?? \App\Support\WebsiteContent::defaultCta();
    $ctaBenefits = $home['cta_benefits'] ?? \App\Support\WebsiteContent::defaultCtaBenefits();
    $footer = $home['footer'] ?? \App\Support\WebsiteContent::defaultFooter();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $hero['title_line_1'] }} {{ $hero['title_line_2'] }} - eproexpo</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { inter: ['Inter', 'sans-serif'] },
          colors: {
            navy: '#071044',
            purple: '#6D28D9',
            violet: '#5726E8',
            coral: '#FF4D3D',
            soft: '#F6F7FC'
          },
          boxShadow: {
            soft: '0 16px 40px rgba(7,16,68,0.08)',
            card: '0 10px 28px rgba(7,16,68,0.07)'
          }
        }
      }
    };
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    html { scroll-behavior: smooth; }
    body { font-family: Inter, sans-serif; }
  </style>
  @include('frontend.shared.partials.responsive-fixes')
  @include('frontend.home.partials.mobile-styles')
</head>
<body id="home-page" class="bg-white text-navy antialiased">
  <!-- Header -->
  <header class="sticky top-0 z-50 border-b border-[#EEF0F7] bg-white/90 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between px-4 py-4 sm:px-6 lg:px-8 lg:py-5">
      <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px] sm:h-[54px] sm:w-[54px] sm:rounded-[18px] sm:text-[24px]" title-class="text-[24px] text-[#071044] sm:text-[30px]" subtitle-class="text-[10px] text-[#8A94AD] sm:text-[12px]" />

      <nav class="hidden items-center gap-10 text-[14px] font-semibold lg:flex">
        <a class="hover:text-violet" href="{{ route('events.home') }}">Explore Events</a>
        <a class="hover:text-violet" href="{{ route('exhibitions.index') }}">Exhibitions</a>
        <a class="hover:text-violet" href="{{ route('frontend.features') }}">Features</a>
        <a class="hover:text-violet" href="{{ route('frontend.pricing') }}">Pricing</a>
        <a class="hover:text-violet" href="{{ route('frontend.about') }}">About Us</a>
      </nav>

      <div class="hidden items-center gap-4 lg:flex">
        <a href="{{ route('events.home') }}" class="rounded-lg bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-3 text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.26)]">Get Started</a>
      </div>

      <button id="menuBtn" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[#E0E4EF] lg:hidden" aria-label="Open menu">
        <span class="text-2xl"><i class="fas fa-bars"></i></span>
      </button>
    </div>

    <div id="mobileMenu" class="hidden border-t border-[#EEF0F7] bg-white px-4 py-5 sm:px-6 lg:hidden">
      <div class="flex flex-col gap-4 text-[15px] font-semibold">
        <a href="{{ route('events.home') }}">Explore Events</a>
        <a href="{{ route('exhibitions.index') }}">Exhibitions</a>
        <a href="{{ route('frontend.features') }}">Features</a>
        <a href="{{ route('frontend.pricing') }}">Pricing</a>
        <a href="{{ route('frontend.about') }}">About Us</a>
        <div class="grid grid-cols-1 gap-3 pt-2">
          <a href="{{ route('company.home') }}" class="rounded-lg border border-[#D8DCEB] px-5 py-3 text-center font-bold text-navy">Book a Booth</a>
          <a href="{{ route('company.event-company.login') }}" class="rounded-lg border border-[#D8DCEB] px-5 py-3 text-center font-bold text-navy">Create Event</a>
          <a href="{{ route('events.home') }}" class="rounded-lg bg-violet px-5 py-3 text-center font-bold text-white">Get Started</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <main>
    <section class="home-hero relative overflow-hidden bg-white pb-4 lg:min-h-[620px] lg:pb-0">
      <img src="{{ $hero['image_url'] }}" alt="eproexpo virtual event building" class="absolute inset-y-0 right-0 hidden h-full w-[72%] object-cover object-right-top lg:block" />
      <img src="{{ $hero['image_url'] }}" alt="eproexpo virtual event building" class="home-hero-image-mobile absolute inset-x-0 top-0 h-[260px] w-full object-cover object-center opacity-20 sm:h-[340px] lg:hidden" />
      <div class="home-hero-overlay-desktop absolute inset-0 hidden lg:block" style="background: linear-gradient(90deg, #fff 0%, #fff 27%, rgba(255,255,255,0.98) 34%, rgba(255,255,255,0.82) 39%, rgba(255,255,255,0.46) 44%, rgba(255,255,255,0.12) 50%, rgba(255,255,255,0) 58%);"></div>
      <div class="home-hero-overlay-mobile absolute inset-0 lg:hidden"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-white/0 via-white/0 via-[76%] to-white/78 lg:block"></div>
      <div class="relative z-10 mx-auto grid max-w-[1440px] items-start gap-10 px-4 pb-12 pt-7 sm:px-6 sm:pb-20 lg:min-h-[384px] lg:grid-cols-[0.76fr_1.24fr] lg:px-8 lg:pb-0 lg:pt-7">
        <div class="relative z-10 min-w-0">
          <h1 class="home-hero-title max-w-[555px] text-[38px] font-black leading-[1.02] tracking-[-0.045em] text-navy min-[420px]:text-[44px] sm:text-[62px] sm:leading-[0.97] lg:text-[68px]">
            {{ $hero['title_line_1'] }}<br />{{ $hero['title_line_2'] }}<br />
            <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">{{ $hero['title_highlight'] }}</span>
          </h1>
          <p class="home-hero-copy mt-5 max-w-[520px] text-[15px] font-medium leading-[1.65] text-[#1F2B55] sm:text-[17px] sm:leading-[1.55]">
            {{ $hero['subtitle'] }}
          </p>
          <div class="home-hero-actions mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-5">
            <a href="{{ $hero['button_1_url'] ?? route('events.home') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-4 text-[15px] font-bold text-white shadow-[0_14px_30px_rgba(91,46,255,0.28)] sm:w-auto sm:px-7 sm:text-[16px]">
              <i class="far fa-calendar-alt text-lg"></i> {{ $hero['button_1_label'] ?? 'Explore Events' }}
            </a>
            <a href="{{ $hero['button_2_url'] ?? url('/exhibitions') }}" class="group inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-6 py-4 text-[15px] font-bold text-navy shadow-sm transition-all duration-200 hover:border-transparent hover:bg-gradient-to-r hover:from-[#6D28D9] hover:to-[#4B16D8] hover:text-white hover:shadow-[0_14px_30px_rgba(91,46,255,0.28)] sm:w-auto sm:px-7 sm:text-[16px]">
              <i class="far fa-building text-lg text-gray-500 transition-colors group-hover:text-white"></i> {{ $hero['button_2_label'] ?? 'Explore Exhibitions' }}
            </a>
            <div class="grid w-full grid-cols-2 gap-3 sm:flex sm:w-auto sm:gap-8">
              <a href="{{ $hero['button_3_url'] ?? route('company.home') }}" class="group inline-flex items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-4 py-4 text-[14px] font-bold text-navy shadow-sm transition-all duration-200 hover:border-transparent hover:bg-gradient-to-r hover:from-[#6D28D9] hover:to-[#4B16D8] hover:text-white hover:shadow-[0_14px_30px_rgba(91,46,255,0.28)] sm:px-7 sm:text-[16px]">
                <i class="fas fa-store text-lg text-[#FF9B41] transition-colors group-hover:text-white"></i> {{ $hero['button_3_label'] ?? 'Book a Booth' }}
              </a>
              <a href="{{ $hero['button_4_url'] ?? route('company.event-company.login') }}" class="group inline-flex items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-4 py-4 text-[14px] font-bold text-navy shadow-sm transition-all duration-200 hover:border-transparent hover:bg-gradient-to-r hover:from-[#6D28D9] hover:to-[#4B16D8] hover:text-white hover:shadow-[0_14px_30px_rgba(91,46,255,0.28)] sm:px-7 sm:text-[16px]">
                <i class="fas fa-calendar-plus text-lg text-[#6D28D9] transition-colors group-hover:text-white"></i> {{ $hero['button_4_label'] ?? 'Create Company Event' }}
              </a>
            </div>
          </div>
        </div>

        <div class="hidden min-h-[384px] lg:block"></div>
      </div>

      <div class="relative z-20 mx-auto mt-4 max-w-[1440px] px-4 pb-8 sm:px-6 lg:px-8">
        <div class="grid items-center gap-5 lg:grid-cols-[1.02fr_1fr]">
          <div class="grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 sm:grid-cols-4">
            @foreach ($stats as $stat)
              @php($statUrl = $stat['link_url'] ?? null)
              @if ($statUrl)
                <a href="{{ $statUrl }}" class="flex items-center gap-3 rounded-xl border border-[#E7EAF3] bg-white p-3 shadow-sm transition-colors hover:border-[#6D28D9]">
              @else
                <div class="flex items-center gap-3 rounded-xl border border-[#E7EAF3] bg-white p-3 shadow-sm">
              @endif
                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full text-white" style="background-color: {{ $stat['color'] ?? '#6325E6' }}">
                  <i class="{{ $stat['icon'] ?? 'fa-solid fa-store' }} text-lg"></i>
                </span>
                <p class="text-[13px] font-bold leading-tight">{{ $stat['title'] ?? '' }}<br><span class="font-medium">{{ $stat['subtitle'] ?? '' }}</span></p>
              @if ($statUrl)
                </a>
              @else
                </div>
              @endif
            @endforeach
          </div>
          <div class="home-pills-wrap">
            <div class="home-pills-grid grid grid-cols-2 gap-2 rounded-2xl bg-white p-3 shadow-soft min-[480px]:grid-cols-3 sm:grid-cols-6 sm:p-4">
            @foreach ($featurePills as $pill)
              <a href="{{ $pill['link_url'] ?? route('exhibitions.index') }}" class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] transition-colors">
                <div class="text-[20px] mb-1.5"><i class="{{ $pill['icon'] ?? 'far fa-circle' }}"></i></div>{{ $pill['title'] ?? '' }}
              </a>
            @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="bg-[#F8F8FC] px-5 py-8 lg:px-8">
      <div class="mx-auto max-w-[1440px]">
        <div class="text-center">
          <h2 class="text-[18px] font-extrabold tracking-[-0.02em] text-[#071044] sm:text-[21px]">Everything You Need, In One Platform</h2>
          <div class="mx-auto mt-3 h-[2px] w-[58px] rounded-full bg-gradient-to-r from-[#6D28D9] via-[#C640CF] to-[#FF9B41]"></div>
        </div>

        <div class="home-features-grid mt-6 grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
          @foreach ($features as $feature)
            <article class="home-feature-card min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1">
              <span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full text-[24px] text-white" style="background-color: {{ $feature['color'] ?? '#8B2DE8' }}"><i class="{{ $feature['icon'] ?? 'far fa-circle' }}"></i></span>
              <h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">{!! nl2br(e($feature['title'] ?? '')) !!}</h3>
              <p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">{{ $feature['body'] ?? '' }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Experience -->
    <section id="exhibitions" class="bg-white px-4 py-8 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-[1440px] gap-6 lg:grid-cols-[300px_1fr]">
        <aside class="home-steps-panel relative z-10 overflow-hidden rounded-[14px] bg-[#071A55] px-5 py-7 text-white shadow-[0_14px_34px_rgba(7,16,68,0.18)]">
          <h2 class="text-center text-[21px] font-extrabold leading-none">How It Works</h2>
          <div class="relative mt-8 space-y-7">
            <div class="absolute bottom-10 left-[31px] top-9 border-l-2 border-dashed border-white/22"></div>
            @foreach ($steps as $index => $step)
              <div class="home-step-item relative grid grid-cols-[64px_1fr] gap-5">
                <span class="home-step-icon relative z-10 grid h-[62px] w-[62px] place-items-center rounded-full text-[26px] text-white shadow-[0_8px_20px_rgba(0,0,0,0.15)]" style="background-color: {{ $step['color'] ?? '#8B2DE8' }}"><i class="{{ $step['icon'] ?? 'fas fa-circle' }}"></i></span>
                <div class="pt-1">
                  <div class="flex items-center gap-3"><span class="grid h-7 w-7 place-items-center rounded-full bg-white text-[14px] font-extrabold text-[#6D28D9]">{{ $step['step'] ?? ($index + 1) }}</span><h3 class="text-[15px] font-extrabold">{{ $step['title'] ?? '' }}</h3></div>
                  <p class="mt-2 text-[12px] font-medium leading-[1.55] text-white/88">{{ $step['body'] ?? '' }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </aside>

        <div class="min-w-0">
          <h2 class="mb-5 text-[23px] font-extrabold tracking-[-0.03em]">Virtual Exhibition Experience</h2>
          
          <div class="flex flex-col gap-6 xl:flex-row xl:items-start">
            <div class="flex-1 overflow-hidden rounded-2xl border border-[#DCE1EE] bg-[#F8F9FD] shadow-card" id="experience-preview-container">
              <div class="home-tab-row flex gap-2 overflow-x-auto border-b border-[#DCE1EE] px-4 py-3 text-[13px] font-bold sm:px-8 sm:py-4">
                @foreach ($experienceTabs as $index => $tab)
                  <button class="rounded-lg {{ $index === 0 ? 'bg-[#6D28D9] text-white shadow active' : 'transition-colors hover:bg-white' }} px-5 py-2.5 sm:px-6 sm:py-3 tab-btn" data-img="{{ $tab['image_url'] ?? '' }}">{{ $tab['title'] ?? '' }}</button>
                @endforeach
              </div>
              @if (!empty($experienceTabs))
                <img src="{{ $experienceTabs[0]['image_url'] ?? '' }}" alt="Virtual exhibition lobby" id="experience-preview-img" class="h-[220px] w-full object-cover sm:h-[340px] xl:h-[390px]" />
              @endif
            </div>

            <aside class="w-full shrink-0 rounded-xl border border-[#E7EAF3] bg-white p-5 shadow-card xl:w-[280px]">
              <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div class="text-[18px] font-black">{{ $boothHighlight['initials'] ?? 'EX' }}</div>
                <div class="text-[14px] font-extrabold">{{ $boothHighlight['company_name'] ?? 'Exhibitor' }}</div>
                <span class="rounded-full bg-[#E9FFF2] px-2 py-1 text-[10px] font-bold text-[#0A9A55] border border-green-200">{{ $boothHighlight['status'] ?? 'ONLINE' }}</span>
              </div>
              <img src="{{ $boothHighlight['image_url'] ?? asset('images/home/booth-preview-new.png') }}" alt="{{ $boothHighlight['company_name'] ?? 'Exhibitor' }} booth" class="h-[120px] w-full rounded-lg object-cover" />
              <h3 class="mt-5 text-[15px] font-extrabold">{{ $boothHighlight['tagline'] ?? '' }}</h3>
              <p class="mt-3 text-[13px] font-medium leading-6 text-[#1F2B55]">{{ $boothHighlight['description'] ?? '' }}</p>
              <div class="home-booth-actions mt-5 grid grid-cols-1 gap-3 min-[420px]:grid-cols-2">
                <a href="{{ $boothHighlight['link_url'] ?? '#' }}" class="rounded-lg bg-[#6D28D9] hover:bg-[#5726E8] px-3 py-3 text-[12px] font-bold text-white transition-colors text-center block"><i class="far fa-comment-dots mr-1"></i> Chat Now</a>
                <a href="{{ $boothHighlight['link_url'] ?? '#' }}" class="rounded-lg border border-[#DCE1EE] hover:bg-[#F8F7FF] px-3 py-3 text-[12px] font-bold transition-colors text-center block"><i class="far fa-file-alt mr-1"></i> View Brochure</a>
              </div>
              <a href="{{ $boothHighlight['link_url'] ?? '#' }}" class="mt-3 w-full rounded-lg border border-[#DCE1EE] hover:bg-[#F8F7FF] px-3 py-3 text-[12px] font-bold transition-colors text-center block"><i class="far fa-calendar-alt mr-1"></i> Book Meeting</a>
            </aside>
          </div>
        </div>
      </div>
    </section>

    <!-- Trust -->
    <section class="bg-white px-4 pb-4 pt-7 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-[1440px] text-center">
        <p class="text-[15px] font-extrabold text-[#071044]">Trusted by Organizations Worldwide</p>
        <div class="home-partners-row mt-5 flex flex-wrap items-center justify-center gap-x-7 gap-y-4 text-[17px] font-bold text-[#8C91A0] sm:gap-x-12 sm:gap-y-5 sm:text-[23px]">
          @foreach ($partners as $partner)
            @php($style = $partner['meta']['style'] ?? null)
            @if ($style === 'unilever')
              <span class="flex flex-col items-center leading-none"><span class="text-[26px] font-black text-[#8C91A0] sm:text-[32px]">U</span><span class="mt-0.5 text-[8px] uppercase tracking-widest sm:text-[9px]">{{ $partner['title'] ?? 'Unilever' }}</span></span>
            @elseif ($style === 'serif')
              <span class="font-serif italic text-[24px] sm:text-[30px]">{{ $partner['title'] ?? '' }}</span>
            @elseif ($style === 'serif-lg')
              <span class="font-serif text-[23px] font-medium sm:text-[29px]">{{ $partner['title'] ?? '' }}</span>
            @elseif ($style === 'tracking' || $style === 'tracking-sm')
              <span class="{{ $style === 'tracking-sm' ? 'text-[17px] tracking-widest sm:text-[20px]' : 'tracking-widest' }}">{{ $partner['title'] ?? '' }}</span>
            @elseif (! empty($partner['icon']))
              <span class="flex items-center gap-2"><i class="{{ $partner['icon'] }} text-[20px]"></i> {{ $partner['title'] ?? '' }}</span>
            @else
              <span class="font-medium">{{ $partner['title'] ?? '' }}</span>
            @endif
          @endforeach
        </div>
      </div>
    </section>

    <!-- CTA + Footer -->
    <section id="pricing" class="px-0 pb-0 sm:px-3 lg:px-3">
      <div class="mx-auto max-w-[1440px] overflow-hidden rounded-t-[16px] bg-gradient-to-r from-[#5522E6] via-[#9A31D5] to-[#FF4D3D] text-white">
        <div class="grid items-start gap-8 px-5 py-8 sm:px-8 sm:py-9 lg:grid-cols-[1fr_auto] lg:px-[72px]">
          <div>
            <h2 class="text-[25px] font-extrabold leading-tight sm:text-[31px]">{{ $cta['title'] }}</h2>
            <p class="mt-4 max-w-[560px] text-[15px] font-medium leading-7 text-white/90 sm:mt-5 sm:text-[16px]">{{ $cta['subtitle'] }}</p>
          </div>
          <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:flex-wrap sm:items-center sm:gap-5 lg:gap-8 lg:pt-4">
            <a class="w-full rounded-xl bg-white px-7 py-4 text-center text-[15px] font-extrabold text-violet shadow-xl transition-colors hover:bg-gray-50 sm:w-auto sm:px-12" href="{{ $cta['button_1_url'] ?? route('events.home') }}">{{ $cta['button_1_label'] ?? 'Get Started Free' }}</a>
            <a class="w-full rounded-xl border border-white/55 px-7 py-4 text-center text-[15px] font-extrabold transition-colors hover:bg-white/10 sm:w-auto sm:px-12" href="{{ $cta['button_2_url'] ?? route('company.home') }}">{{ $cta['button_2_label'] ?? 'Exhibit Your Company' }}</a>
          </div>
        </div>
        <div class="home-cta-benefits grid gap-5 px-5 pb-8 pt-2 text-[14px] font-semibold sm:grid-cols-2 sm:px-8 lg:grid-cols-4 lg:gap-7 lg:px-[180px]">
          @foreach ($ctaBenefits as $benefit)
            <div class="flex items-center gap-4">
              <span class="flex h-10 w-10 items-center justify-center text-[27px] text-white/85"><i class="{{ $benefit['icon'] ?? 'far fa-check-square' }}"></i></span>
              <div>
                <p class="text-[15px]">{{ $benefit['title'] ?? '' }}</p>
                <p class="text-[13px] font-medium text-white/80">{{ $benefit['subtitle'] ?? '' }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <footer class="home-footer-wrap mx-auto max-w-[1440px] bg-[#071044] px-5 py-6 text-white sm:px-8 lg:px-10">
        <div class="flex flex-col items-center justify-between gap-6 text-center lg:flex-row lg:text-left">
          <div class="rounded-2xl bg-white px-3 py-2">
            <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-10 w-10 rounded-[14px] text-[19px]" title-class="text-[23px] text-[#071044]" subtitle-class="text-[10px] text-[#8A94AD]" />
          </div>
          <p class="text-[13px] text-white/70">{{ $footer['copyright'] }}</p>
          <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-[13px] font-medium text-white/80 lg:gap-9">
            @foreach (($footer['links'] ?? []) as $link)
              <a href="{{ $link['link_url'] ?? '#' }}" class="transition-colors hover:text-white">{{ $link['title'] ?? '' }}</a>
            @endforeach
            @if (! empty($footer['contact_email']))
              <a href="mailto:{{ $footer['contact_email'] }}" class="transition-colors hover:text-white">{{ $footer['contact_email'] }}</a>
            @endif
          </div>
          <div class="flex gap-3">
            @foreach (($footer['social'] ?? []) as $social)
              <a href="{{ $social['link_url'] ?? '#' }}" class="grid h-9 w-9 place-items-center rounded-full bg-white/15 text-[14px] transition-colors hover:bg-[#6D28D9]"><i class="{{ $social['icon'] ?? 'fab fa-linkedin-in' }}"></i></a>
            @endforeach
          </div>
        </div>
      </footer>
    </section>
  </main>

  <script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

    document.querySelectorAll('#mobileMenu a').forEach(link => {
      link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    document.querySelectorAll('#experience-preview-container .tab-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        // Remove active class from all buttons in container
        document.querySelectorAll('#experience-preview-container .tab-btn').forEach(b => {
          b.classList.remove('bg-[#6D28D9]', 'text-white', 'shadow');
          b.classList.add('transition-colors', 'hover:bg-white');
        });
        // Add active class to clicked button
        this.classList.add('bg-[#6D28D9]', 'text-white', 'shadow');
        this.classList.remove('hover:bg-white');
        
        // Update image src
        document.getElementById('experience-preview-img').src = this.dataset.img;
      });
    });
  </script>
</body>
</html>
