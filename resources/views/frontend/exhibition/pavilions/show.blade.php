@php
    $slug = 'innovation-expo';
    $companySlug = $companySlug ?? 'technova-solutions';
    $isPassActive = $isPassActive ?? false;
@endphp

@include('frontend.exhibitions.booths.show', ['slug' => $slug, 'companySlug' => $companySlug, 'isPassActive' => $isPassActive])
