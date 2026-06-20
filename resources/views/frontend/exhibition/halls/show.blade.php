@php
    $slug = $slug ?? 'innovation-expo';
    $isPassActive = $isPassActive ?? false;
@endphp

@include('frontend.exhibition.halls.floor-map', ['slug' => $slug, 'isPassActive' => $isPassActive])
