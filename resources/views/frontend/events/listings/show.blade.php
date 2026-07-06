@extends('layouts.frontend')

@section('title', $event['title'] . ' — eproexpo')

@push('head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @include('frontend.events.listings.partials.event-show-styles')
@endpush

@section('content')
  <div id="event-show-page" class="w-full max-w-full overflow-x-clip bg-white">
    @include('frontend.events.listings.partials.event-show-content')
  </div>
@endsection
