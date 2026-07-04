@extends('frontend.pages.layout', [
    'pageTitle' => 'About Us',
    'activeNav' => 'about',
])

@push('head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @include('frontend.pages.partials.about-styles')
@endpush

@section('content')
  <div id="about-page" class="-mx-4 -mt-5 overflow-x-hidden bg-white sm:-mx-6 sm:-mt-7 lg:-mx-8">
    @include('frontend.pages.partials.about-content', [
        'aboutHero' => $aboutHero ?? [],
        'sectionHeadings' => $sectionHeadings ?? [],
        'values' => $values ?? [],
        'stats' => $stats ?? [],
        'milestones' => $milestones ?? [],
        'partners' => $partners ?? [],
    ])
  </div>
@endsection
