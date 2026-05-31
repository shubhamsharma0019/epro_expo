<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>eproexpo - Events & Exhibitions Platform</title>
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
</head>
<body class="bg-white text-navy antialiased">
  <!-- Header -->
  <header class="sticky top-0 z-50 border-b border-[#EEF0F7] bg-white/90 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between px-4 py-4 sm:px-6 lg:px-8 lg:py-5">
      <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-11 w-11 rounded-[16px] text-[20px] sm:h-[54px] sm:w-[54px] sm:rounded-[18px] sm:text-[24px]" title-class="text-[24px] text-[#071044] sm:text-[30px]" subtitle-class="text-[10px] text-[#8A94AD] sm:text-[12px]" />

      <nav class="hidden items-center gap-10 text-[14px] font-semibold lg:flex">
        <a class="hover:text-violet" href="{{ route('events.home') }}">Explore Events</a>
        <a class="hover:text-violet" href="{{ url('/exhibitions') }}">Exhibitions</a>
        <a class="hover:text-violet" href="#features">Features</a>
        <a class="hover:text-violet" href="#pricing">Pricing</a>
        <a class="hover:text-violet" href="#about">About Us</a>
      </nav>

      <div class="hidden items-center gap-4 lg:flex">
        <a href="{{ route('company.dashboard') }}" class="rounded-lg border border-[#D8DCEB] bg-white px-5 py-3 text-[14px] font-bold text-navy shadow-sm hover:bg-[#F8F7FF]">Book a Booth</a>
        <a href="{{ route('company.event-company.login') }}" class="rounded-lg border border-[#D8DCEB] bg-white px-5 py-3 text-[14px] font-bold text-navy shadow-sm hover:bg-[#F8F7FF]">Create Event</a>
        <a href="{{ route('events.home') }}" class="rounded-lg bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-3 text-[14px] font-bold text-white shadow-[0_12px_24px_rgba(91,46,255,0.26)]">Get Started</a>
      </div>

      <button id="menuBtn" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[#E0E4EF] lg:hidden" aria-label="Open menu">
        <span class="text-2xl"><i class="fas fa-bars"></i></span>
      </button>
    </div>

    <div id="mobileMenu" class="hidden border-t border-[#EEF0F7] bg-white px-4 py-5 sm:px-6 lg:hidden">
      <div class="flex flex-col gap-4 text-[15px] font-semibold">
        <a href="{{ route('events.home') }}">Explore Events</a>
        <a href="{{ url('/exhibitions') }}">Exhibitions</a>
        <a href="#features">Features</a>
        <a href="#pricing">Pricing</a>
        <a href="#about">About Us</a>
        <div class="grid grid-cols-1 gap-3 pt-2">
          <a href="{{ route('company.dashboard') }}" class="rounded-lg border border-[#D8DCEB] px-5 py-3 text-center font-bold text-navy">Book a Booth</a>
          <a href="{{ route('company.event-company.login') }}" class="rounded-lg border border-[#D8DCEB] px-5 py-3 text-center font-bold text-navy">Create Event</a>
          <a href="{{ route('events.home') }}" class="rounded-lg bg-violet px-5 py-3 text-center font-bold text-white">Get Started</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <main>
    <section class="relative overflow-hidden bg-white pb-4 lg:min-h-[510px] lg:pb-0">
      <img src="{{ asset('images/home/hero-expo-new-clear.png') }}" alt="eproexpo virtual event building" class="absolute bottom-0 right-0 hidden h-full w-[72%] object-contain object-right-bottom lg:block" />
      <img src="{{ asset('images/home/hero-expo-new-clear.png') }}" alt="eproexpo virtual event building" class="absolute inset-x-0 bottom-0 h-[38%] w-full object-cover object-center opacity-20 sm:h-[46%] lg:hidden" />
      <div class="absolute inset-0" style="background: linear-gradient(90deg, #fff 0%, #fff 27%, rgba(255,255,255,0.98) 34%, rgba(255,255,255,0.82) 39%, rgba(255,255,255,0.46) 44%, rgba(255,255,255,0.12) 50%, rgba(255,255,255,0) 58%);"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-white/0 via-white/0 via-[76%] to-white/78"></div>
      <div class="relative z-10 mx-auto grid max-w-[1440px] items-start gap-10 px-4 pb-12 pt-7 sm:px-6 sm:pb-20 lg:min-h-[384px] lg:grid-cols-[0.76fr_1.24fr] lg:px-8 lg:pb-0 lg:pt-7">
        <div class="relative z-10">
          <h1 class="max-w-[555px] text-[38px] font-black leading-[1.02] tracking-[-0.045em] text-navy min-[420px]:text-[44px] sm:text-[62px] sm:leading-[0.97] lg:text-[68px]">
            Millions of<br />Small Events.<br />
            <span class="bg-gradient-to-r from-[#6D28D9] to-[#B735D7] bg-clip-text text-transparent">Limitless Opportunities.</span>
          </h1>
          <p class="mt-5 max-w-[520px] text-[15px] font-medium leading-[1.65] text-[#1F2B55] sm:text-[17px] sm:leading-[1.55]">
            For details and ticketing of any event - big or small. And virtual exhibitions that bring the world together, with pavilions, halls and booths - just like offline, only better.
          </p>
          <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-5">
            <a href="{{ route('events.home') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-[#6D28D9] to-[#4B16D8] px-6 py-4 text-[15px] font-bold text-white shadow-[0_14px_30px_rgba(91,46,255,0.28)] sm:w-auto sm:px-7 sm:text-[16px]">
              <i class="far fa-calendar-alt text-lg"></i> Explore Events
            </a>
            <a href="{{ url('/exhibitions') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-6 py-4 text-[15px] font-bold text-navy shadow-sm hover:bg-[#F8F7FF] sm:w-auto sm:px-7 sm:text-[16px]">
              <i class="far fa-building text-lg text-gray-500"></i> Explore Exhibitions
            </a>
            <a href="{{ route('company.dashboard') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-6 py-4 text-[15px] font-bold text-navy shadow-sm hover:bg-[#F8F7FF] sm:w-auto sm:px-7 sm:text-[16px]">
              <i class="fas fa-store text-lg text-[#FF9B41]"></i> Book a Booth
            </a>
            <a href="{{ route('company.event-company.login') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-xl border border-[#D8DCEB] bg-white px-6 py-4 text-[15px] font-bold text-navy shadow-sm hover:bg-[#F8F7FF] sm:w-auto sm:px-7 sm:text-[16px]">
              <i class="fas fa-calendar-plus text-lg text-[#6D28D9]"></i> Create Company Event
            </a>
          </div>
        </div>

        <div class="hidden min-h-[384px] lg:block"></div>
      </div>

      <div class="relative z-20 mx-auto max-w-[1440px] px-4 pb-8 sm:-mt-5 sm:px-6 lg:-mt-2 lg:px-8">
        <div class="grid items-center gap-5 lg:grid-cols-[1.02fr_1fr]">
          <div class="grid grid-cols-1 gap-3 min-[420px]:grid-cols-2 sm:grid-cols-4 sm:gap-5">
            <div class="flex items-center gap-3 rounded-xl bg-white/90 p-3 shadow-sm sm:bg-transparent sm:p-0 sm:shadow-none"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-[#6325E6] text-white sm:h-12 sm:w-12"><i class="far fa-calendar-check text-lg sm:text-xl"></i></span><p class="text-[13px] font-bold leading-tight sm:text-[14px]">Millions<br /><span class="font-medium">of Events</span></p></div>
            <div class="flex items-center gap-3 rounded-xl bg-white/90 p-3 shadow-sm sm:bg-transparent sm:p-0 sm:shadow-none"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-[#FF9B41] text-white sm:h-12 sm:w-12"><i class="fas fa-users text-lg sm:text-xl"></i></span><p class="text-[13px] font-bold leading-tight sm:text-[14px]">Thousands<br /><span class="font-medium">of Organizers</span></p></div>
            <div class="flex items-center gap-3 rounded-xl bg-white/90 p-3 shadow-sm sm:bg-transparent sm:p-0 sm:shadow-none"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-[#3478E5] text-white sm:h-12 sm:w-12"><i class="fas fa-ticket-alt text-lg sm:text-xl"></i></span><p class="text-[13px] font-bold leading-tight sm:text-[14px]">Millions<br /><span class="font-medium">of Tickets Sold</span></p></div>
            <div class="flex items-center gap-3 rounded-xl bg-white/90 p-3 shadow-sm sm:bg-transparent sm:p-0 sm:shadow-none"><span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-[#48C4AE] text-white sm:h-12 sm:w-12"><i class="fas fa-globe text-lg sm:text-xl"></i></span><p class="text-[13px] font-bold leading-tight sm:text-[14px]">Global<br /><span class="font-medium">Community</span></p></div>
          </div>
          <div class="grid grid-cols-2 gap-2 rounded-2xl bg-white p-3 shadow-soft min-[480px]:grid-cols-3 sm:grid-cols-6 sm:p-4">
            <div class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] cursor-pointer transition-colors"><div class="text-[20px] mb-1.5"><i class="far fa-comment-dots"></i></div>Live Chat</div>
            <div class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] cursor-pointer transition-colors"><div class="text-[20px] mb-1.5"><i class="fas fa-video"></i></div>Video Call</div>
            <div class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] cursor-pointer transition-colors"><div class="text-[20px] mb-1.5"><i class="far fa-file-alt"></i></div>Brochures</div>
            <div class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] cursor-pointer transition-colors"><div class="text-[20px] mb-1.5"><i class="far fa-question-circle"></i></div>Enquiries</div>
            <div class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] cursor-pointer transition-colors"><div class="text-[20px] mb-1.5"><i class="far fa-calendar-alt"></i></div>Appointments</div>
            <div class="text-center text-[12px] font-semibold text-gray-700 hover:text-[#6D28D9] cursor-pointer transition-colors"><div class="text-[20px] mb-1.5"><i class="fas fa-trophy"></i></div>Leaderboard</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Flow Entry Points -->
    <section class="bg-white px-4 py-8 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-[1440px]">
        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
          <div>
            <p class="text-[12px] font-extrabold uppercase tracking-[0.14em] text-[#6D28D9]">Start here</p>
            <h2 class="mt-2 text-[24px] font-black tracking-[-0.03em] text-[#071044] sm:text-[32px]">Choose your flow</h2>
          </div>
          <p class="max-w-[520px] text-[14px] font-medium leading-6 text-[#5A6480]">Jump directly into the right journey from the home page.</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-4">
          <a href="{{ route('events.home') }}" class="group flex min-h-[168px] flex-col rounded-[14px] border border-[#E7EAF3] bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition hover:-translate-y-1 hover:border-[#6D28D9]">
            <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#F4F0FF] text-[22px] text-[#6D28D9]"><i class="far fa-calendar-alt"></i></span>
            <h3 class="mt-5 text-[20px] font-extrabold text-[#071044]">Event User Flow</h3>
            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">Explore events, view details, book tickets, and access event features.</p>
            <span class="mt-auto pt-5 text-[13px] font-extrabold text-[#6D28D9]">Open Events <i class="fa-solid fa-arrow-right ml-2 text-[12px] transition group-hover:translate-x-1"></i></span>
          </a>

          <a href="{{ url('/exhibitions') }}" class="group flex min-h-[168px] flex-col rounded-[14px] border border-[#E7EAF3] bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition hover:-translate-y-1 hover:border-[#0F9F8F]">
            <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#E9FFF8] text-[22px] text-[#0F9F8F]"><i class="far fa-building"></i></span>
            <h3 class="mt-5 text-[20px] font-extrabold text-[#071044]">Exhibition Visitor Flow</h3>
            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">Browse exhibitions, visit companies, get visitor pass, and open dashboard.</p>
            <span class="mt-auto pt-5 text-[13px] font-extrabold text-[#0F9F8F]">Open Exhibitions <i class="fa-solid fa-arrow-right ml-2 text-[12px] transition group-hover:translate-x-1"></i></span>
          </a>

          <a href="{{ route('company.dashboard') }}" class="group flex min-h-[168px] flex-col rounded-[14px] border border-[#E7EAF3] bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition hover:-translate-y-1 hover:border-[#FF9B41]">
            <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#FFF4E8] text-[22px] text-[#FF8A1D]"><i class="fas fa-store"></i></span>
            <h3 class="mt-5 text-[20px] font-extrabold text-[#071044]">Exhibition Company Flow</h3>
            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">Choose an exhibition, book booth space, and manage exhibitor tools.</p>
            <span class="mt-auto pt-5 text-[13px] font-extrabold text-[#E87510]">Book Booth <i class="fa-solid fa-arrow-right ml-2 text-[12px] transition group-hover:translate-x-1"></i></span>
          </a>

          <a href="{{ route('company.event-company.login') }}" class="group flex min-h-[168px] flex-col rounded-[14px] border border-[#E7EAF3] bg-white p-6 shadow-[0_10px_28px_rgba(7,16,68,0.07)] transition hover:-translate-y-1 hover:border-[#5B32F6]">
            <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#F4F0FF] text-[22px] text-[#5B32F6]"><i class="fas fa-calendar-plus"></i></span>
            <h3 class="mt-5 text-[20px] font-extrabold text-[#071044]">Event Company Flow</h3>
            <p class="mt-2 text-[14px] font-medium leading-6 text-[#5A6480]">Login as a company, create your own event, set tickets, preview, and submit for review.</p>
            <span class="mt-auto pt-5 text-[13px] font-extrabold text-[#5B32F6]">Create Event <i class="fa-solid fa-arrow-right ml-2 text-[12px] transition group-hover:translate-x-1"></i></span>
          </a>
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

        <div class="mt-6 grid gap-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
          <article class="min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1"><span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full bg-[#8B2DE8] text-[25px] text-white"><i class="far fa-calendar-alt"></i></span><h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">Small Events,<br />Big Impact</h3><p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">Create, manage and promote events of any size. From webinars to workshops, concerts to community meetups.</p></article>
          <article class="min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1"><span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full bg-[#FF9B41] text-[24px] text-white"><i class="fas fa-ticket-alt"></i></span><h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">Details &amp; Ticketing<br />Made Simple</h3><p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">Share event details, manage registrations and sell tickets securely with real-time analytics.</p></article>
          <article class="min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1"><span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full bg-[#48C4AE] text-[24px] text-white"><i class="fas fa-university"></i></span><h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">Virtual Exhibitions<br />Redefined</h3><p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">Host stunning virtual exhibitions with pavilions, halls and booths that replicate real-world experiences.</p></article>
          <article class="min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1"><span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full bg-[#3478E5] text-[24px] text-white"><i class="fas fa-store"></i></span><h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">Booths That<br />Engage</h3><p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">Exhibitors can showcase, share documents, videos and interact with visitors seamlessly.</p></article>
          <article class="min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1"><span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full bg-[#8C2FE6] text-[24px] text-white"><i class="fas fa-user-friends"></i></span><h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">Networking That<br />Works</h3><p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">Chat, meet, schedule appointments and build meaningful connections globally.</p></article>
          <article class="min-h-[248px] rounded-[10px] border border-[#E7EAF3] bg-white px-4 py-6 text-center shadow-[0_8px_22px_rgba(7,16,68,0.06)] transition-transform hover:-translate-y-1"><span class="mx-auto grid h-[52px] w-[52px] place-items-center rounded-full bg-[#FF9B41] text-[24px] text-white"><i class="fas fa-chart-bar"></i></span><h3 class="mt-5 text-[15px] font-extrabold leading-snug text-[#071044]">Insights That<br />Matter</h3><p class="mt-4 text-[11px] font-semibold leading-[1.75] text-[#25305B]">Track performance, visitor behavior and engagement with powerful analytics and reports.</p></article>
        </div>
      </div>
    </section>

    <!-- Experience -->
    <section id="exhibitions" class="bg-white px-4 py-8 sm:px-6 lg:px-8">
      <div class="mx-auto grid max-w-[1440px] gap-6 lg:grid-cols-[300px_1fr]">
        <aside class="relative z-10 overflow-hidden rounded-[14px] bg-[#071A55] px-5 py-7 text-white shadow-[0_14px_34px_rgba(7,16,68,0.18)]">
          <h2 class="text-center text-[21px] font-extrabold leading-none">How It Works</h2>
          <div class="relative mt-8 space-y-7">
            <div class="absolute bottom-10 left-[31px] top-9 border-l-2 border-dashed border-white/22"></div>
            
            <div class="relative grid grid-cols-[64px_1fr] gap-5">
              <span class="relative z-10 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#8B2DE8] text-[26px] text-white shadow-[0_8px_20px_rgba(139,45,232,0.32)]"><i class="fas fa-user"></i></span>
              <div class="pt-1">
                <div class="flex items-center gap-3"><span class="grid h-7 w-7 place-items-center rounded-full bg-white text-[14px] font-extrabold text-[#6D28D9]">1</span><h3 class="text-[15px] font-extrabold">Create</h3></div>
                <p class="mt-2 text-[12px] font-medium leading-[1.55] text-white/88">Sign up and create your event or exhibition in minutes.</p>
              </div>
            </div>

            <div class="relative grid grid-cols-[64px_1fr] gap-5">
              <span class="relative z-10 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#FF9B41] text-[26px] text-white shadow-[0_8px_20px_rgba(255,155,65,0.30)]"><i class="far fa-building"></i></span>
              <div class="pt-1">
                <div class="flex items-center gap-3"><span class="grid h-7 w-7 place-items-center rounded-full bg-white text-[14px] font-extrabold text-[#6D28D9]">2</span><h3 class="text-[15px] font-extrabold">Customize</h3></div>
                <p class="mt-2 text-[12px] font-medium leading-[1.55] text-white/88">Build your venue - pavilions, halls, booths and more.</p>
              </div>
            </div>

            <div class="relative grid grid-cols-[64px_1fr] gap-5">
              <span class="relative z-10 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#4A5CF6] text-[26px] text-white shadow-[0_8px_20px_rgba(74,92,246,0.30)]"><i class="far fa-paper-plane"></i></span>
              <div class="pt-1">
                <div class="flex items-center gap-3"><span class="grid h-7 w-7 place-items-center rounded-full bg-white text-[14px] font-extrabold text-[#6D28D9]">3</span><h3 class="text-[15px] font-extrabold">Publish</h3></div>
                <p class="mt-2 text-[12px] font-medium leading-[1.55] text-white/88">Share with your audience and start registrations.</p>
              </div>
            </div>

            <div class="relative grid grid-cols-[64px_1fr] gap-5">
              <span class="relative z-10 grid h-[62px] w-[62px] place-items-center rounded-full bg-[#35C88D] text-[26px] text-white shadow-[0_8px_20px_rgba(53,200,141,0.28)]"><i class="fas fa-users"></i></span>
              <div class="pt-1">
                <div class="flex items-center gap-3"><span class="grid h-7 w-7 place-items-center rounded-full bg-white text-[14px] font-extrabold text-[#6D28D9]">4</span><h3 class="text-[15px] font-extrabold">Engage</h3></div>
                <p class="mt-2 text-[12px] font-medium leading-[1.55] text-white/88">Interact, network and make your event/exhibition a success.</p>
              </div>
            </div>
          </div>
        </aside>

        <div class="min-w-0">
          <h2 class="mb-5 text-[23px] font-extrabold tracking-[-0.03em]">Virtual Exhibition Experience</h2>
          
          <div class="flex flex-col gap-6 xl:flex-row xl:items-start">
            <div class="flex-1 overflow-hidden rounded-2xl border border-[#DCE1EE] bg-[#F8F9FD] shadow-card">
              <div class="flex gap-2 overflow-x-auto border-b border-[#DCE1EE] px-4 py-3 text-[13px] font-bold sm:px-8 sm:py-4">
                <button class="rounded-lg bg-[#6D28D9] px-5 py-2.5 text-white shadow sm:px-6 sm:py-3">Pavilions</button>
                <button class="rounded-lg px-5 py-2.5 transition-colors hover:bg-white sm:px-6 sm:py-3">Halls</button>
                <button class="rounded-lg px-5 py-2.5 transition-colors hover:bg-white sm:px-6 sm:py-3">Booths</button>
              </div>
              <img src="{{ asset('images/home/virtual-exhibition-new.png') }}" alt="Virtual exhibition lobby" class="h-[220px] w-full object-cover sm:h-[340px] xl:h-[390px]" />
            </div>

            <aside class="w-full shrink-0 rounded-xl border border-[#E7EAF3] bg-white p-5 shadow-card xl:w-[280px]">
              <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <div class="text-[18px] font-black">T/C</div>
                <div class="text-[14px] font-extrabold">TechNova Solutions</div>
                <span class="rounded-full bg-[#E9FFF2] px-2 py-1 text-[10px] font-bold text-[#0A9A55] border border-green-200">ONLINE</span>
              </div>
              <img src="{{ asset('images/home/booth-preview-new.png') }}" alt="TechNova booth" class="h-[120px] w-full rounded-lg object-cover" />
              <h3 class="mt-5 text-[15px] font-extrabold">Innovating the Future Together</h3>
              <p class="mt-3 text-[13px] font-medium leading-6 text-[#1F2B55]">We deliver smart solutions that empower businesses to grow faster and smarter.</p>
              <div class="mt-5 grid grid-cols-1 gap-3 min-[420px]:grid-cols-2">
                <button class="rounded-lg bg-[#6D28D9] hover:bg-[#5726E8] px-3 py-3 text-[12px] font-bold text-white transition-colors"><i class="far fa-comment-dots mr-1"></i> Chat Now</button>
                <button class="rounded-lg border border-[#DCE1EE] hover:bg-[#F8F7FF] px-3 py-3 text-[12px] font-bold transition-colors"><i class="far fa-file-alt mr-1"></i> View Brochure</button>
              </div>
              <button class="mt-3 w-full rounded-lg border border-[#DCE1EE] hover:bg-[#F8F7FF] px-3 py-3 text-[12px] font-bold transition-colors"><i class="far fa-calendar-alt mr-1"></i> Book Meeting</button>
            </aside>
          </div>
        </div>
      </div>
    </section>

    <!-- Trust -->
    <section class="bg-white px-4 pb-4 pt-7 sm:px-6 lg:px-8">
      <div class="mx-auto max-w-[1440px] text-center">
        <p class="text-[15px] font-extrabold text-[#071044]">Trusted by Organizations Worldwide</p>
        <div class="mt-5 flex flex-wrap items-center justify-center gap-x-7 gap-y-4 text-[17px] font-bold text-[#8C91A0] sm:gap-x-12 sm:gap-y-5 sm:text-[23px]">
          <span class="font-medium">Google</span>
          <span class="flex items-center gap-2"><i class="fab fa-microsoft text-[20px]"></i> Microsoft</span>
          <span>Deloitte.</span>
          <span class="font-serif italic text-[24px] sm:text-[30px]">P&amp;G</span>
          <span class="flex flex-col items-center leading-none"><span class="text-[26px] font-black text-[#8C91A0] sm:text-[32px]">U</span><span class="mt-0.5 text-[8px] uppercase tracking-widest sm:text-[9px]">Unilever</span></span>
          <span class="tracking-widest">IBM</span>
          <span class="font-serif text-[23px] font-medium sm:text-[29px]">Infosys</span>
          <span class="text-[17px] tracking-widest sm:text-[20px]">SIEMENS</span>
          <span class="text-[18px] sm:text-[21px]">accenture</span>
        </div>
      </div>
    </section>

    <!-- CTA + Footer -->
    <section id="pricing" class="px-0 pb-0 sm:px-3 lg:px-3">
      <div class="mx-auto max-w-[1440px] overflow-hidden rounded-t-[16px] bg-gradient-to-r from-[#5522E6] via-[#9A31D5] to-[#FF4D3D] text-white">
        <div class="grid items-start gap-8 px-5 py-8 sm:px-8 sm:py-9 lg:grid-cols-[1fr_auto] lg:px-[72px]">
          <div>
            <h2 class="text-[25px] font-extrabold leading-tight sm:text-[31px]">Any Event. Every Audience. Everywhere.</h2>
            <p class="mt-4 max-w-[560px] text-[15px] font-medium leading-7 text-white/90 sm:mt-5 sm:text-[16px]">eproexpo is your all-in-one platform for events and exhibitions that connect, engage and deliver results.</p>
          </div>
          <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:flex-wrap sm:items-center sm:gap-5 lg:gap-8 lg:pt-4">
            <a class="w-full rounded-xl bg-white px-7 py-4 text-center text-[15px] font-extrabold text-violet shadow-xl transition-colors hover:bg-gray-50 sm:w-auto sm:px-12" href="{{ route('events.home') }}">Get Started Free</a>
            <a class="w-full rounded-xl border border-white/55 px-7 py-4 text-center text-[15px] font-extrabold transition-colors hover:bg-white/10 sm:w-auto sm:px-12" href="{{ route('company.dashboard') }}">Exhibit Your Company</a>
          </div>
        </div>
        <div class="grid gap-5 px-5 pb-8 pt-2 text-[14px] font-semibold sm:grid-cols-2 sm:px-8 lg:grid-cols-4 lg:gap-7 lg:px-[180px]">
          <div class="flex items-center gap-4"><span class="flex h-10 w-10 items-center justify-center text-[27px] text-white/85"><i class="far fa-check-square"></i></span><div><p class="text-[15px]">Secure Ticketing</p><p class="text-[13px] font-medium text-white/80">100% safe &amp; secure</p></div></div>
          <div class="flex items-center gap-4"><span class="flex h-10 w-10 items-center justify-center text-[27px] text-white/85"><i class="fas fa-chart-line"></i></span><div><p class="text-[15px]">Scalable Platform</p><p class="text-[13px] font-medium text-white/80">For events of any size</p></div></div>
          <div class="flex items-center gap-4"><span class="flex h-10 w-10 items-center justify-center text-[27px] text-white/85"><i class="fas fa-globe"></i></span><div><p class="text-[15px]">Global Reach</p><p class="text-[13px] font-medium text-white/80">Connect worldwide</p></div></div>
          <div class="flex items-center gap-4"><span class="flex h-10 w-10 items-center justify-center text-[27px] text-white/85"><i class="fas fa-headset"></i></span><div><p class="text-[15px]">24/7 Support</p><p class="text-[13px] font-medium text-white/80">We're here to help</p></div></div>
        </div>
      </div>

      <footer class="mx-auto max-w-[1440px] bg-[#071044] px-5 py-6 text-white sm:px-8 lg:px-10">
        <div class="flex flex-col items-center justify-between gap-6 text-center lg:flex-row lg:text-left">
          <div class="rounded-2xl bg-white px-3 py-2">
            <x-shared.brand-logo href="{{ route('home') }}" mark-class="h-10 w-10 rounded-[14px] text-[19px]" title-class="text-[23px] text-[#071044]" subtitle-class="text-[10px] text-[#8A94AD]" />
          </div>
          <p class="text-[13px] text-white/70">&copy; 2024 eproexpo. All rights reserved.</p>
          <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-[13px] font-medium text-white/80 lg:gap-9"><a href="#" class="transition-colors hover:text-white">Privacy Policy</a><a href="#" class="transition-colors hover:text-white">Terms of Service</a><a href="#" class="transition-colors hover:text-white">Contact Us</a></div>
          <div class="flex gap-3">
            <a href="#" class="grid h-9 w-9 place-items-center rounded-full bg-white/15 text-[14px] transition-colors hover:bg-[#6D28D9]"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="grid h-9 w-9 place-items-center rounded-full bg-white/15 text-[14px] transition-colors hover:bg-[#6D28D9]"><i class="fab fa-twitter"></i></a>
            <a href="#" class="grid h-9 w-9 place-items-center rounded-full bg-white/15 text-[14px] transition-colors hover:bg-[#6D28D9]"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="grid h-9 w-9 place-items-center rounded-full bg-white/15 text-[14px] transition-colors hover:bg-[#6D28D9]"><i class="fab fa-youtube"></i></a>
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
  </script>
</body>
</html>
