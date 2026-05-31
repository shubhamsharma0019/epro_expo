@php
    $slug = $slug ?? 'innovation-expo';
    $isPassActive = $isPassActive ?? false;
@endphp

@include('exhibition.halls.floor-map', ['slug' => $slug, 'isPassActive' => $isPassActive])
