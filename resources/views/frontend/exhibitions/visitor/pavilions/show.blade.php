@php
    $slug = $slug ?? 'innovation-expo';
    $isPassActive = $isPassActive ?? false;
@endphp

@include('frontend.exhibitions.visitor.companies.index', ['slug' => $slug, 'isPassActive' => $isPassActive])
