@php
    $slug = $slug ?? 'innovation-expo';
    $isPassActive = $isPassActive ?? false;
@endphp

@include('frontend.visitor-exhibition.booths.companies', ['slug' => $slug, 'isPassActive' => $isPassActive, 'booths' => $booths ?? collect()])
