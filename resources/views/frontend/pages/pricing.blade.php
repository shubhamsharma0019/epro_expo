@extends('frontend.pages.layout', [
    'pageTitle' => 'Pricing',
    'activeNav' => 'pricing',
])

@php
    $contactEmail = \App\Support\WebsiteContent::pricingHero()['contact_email']
        ?? \App\Support\WebsiteContent::footer()['contact_email']
        ?? 'hello@eproexpo.com';
@endphp

@push('head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @include('frontend.pages.partials.pricing-styles')
@endpush

@section('content')
  <div id="pricing-page" class="-mx-4 -mt-5 bg-white sm:-mx-6 sm:-mt-7 lg:-mx-8">
    @include('frontend.pages.partials.pricing-content')
  </div>
@endsection

@push('scripts')
  <script>
    document.querySelectorAll('#pricing-page .pp-faq-q').forEach((question) => {
      const toggle = () => {
        const item = question.parentElement;
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('#pricing-page .pp-faq-item').forEach((node) => {
          node.classList.remove('open');
          node.querySelector('.pp-faq-q')?.setAttribute('aria-expanded', 'false');
        });
        if (! isOpen) {
          item.classList.add('open');
          question.setAttribute('aria-expanded', 'true');
        }
      };

      question.addEventListener('click', toggle);
      question.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          toggle();
        }
      });
    });

    const perEvent = document.getElementById('pp-tgl-event');
    const annual = document.getElementById('pp-tgl-annual');

    if (perEvent && annual) {
      perEvent.addEventListener('click', () => {
        perEvent.classList.add('active');
        annual.classList.remove('active');
        perEvent.setAttribute('aria-selected', 'true');
        annual.setAttribute('aria-selected', 'false');
      });

      annual.addEventListener('click', () => {
        annual.classList.add('active');
        perEvent.classList.remove('active');
        annual.setAttribute('aria-selected', 'true');
        perEvent.setAttribute('aria-selected', 'false');
      });
    }

    const contactForm = document.getElementById('pp-contact-form');
    const contactEmail = @json($contactEmail);

    if (contactForm && contactEmail) {
      contactForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const email = document.getElementById('pp-contact-email')?.value || '';
        const body = encodeURIComponent('From: ' + email + '\n\n');
        window.location.href = 'mailto:' + contactEmail + '?subject=' + encodeURIComponent('Pricing question') + '&body=' + body;
      });
    }
  </script>
@endpush
