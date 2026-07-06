@extends('layouts.frontend')

@section('title', ($title ?? 'Exhibition') . ' — eproexpo')

@push('head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  @include('frontend.exhibitions.partials.exhibition-show-styles')
@endpush

@section('content')
  <div id="exhibition-show-page" class="w-full max-w-full overflow-x-clip bg-white">
    @include('frontend.exhibitions.partials.exhibition-show-content')
  </div>
@endsection

@push('scripts')
<script>
  function switchExhibitionTab(tabId, el, updateHash = true) {
    document.querySelectorAll('#exhibition-show-page .ex-tab-panel').forEach(panel => panel.classList.add('hidden'));

    const targetPanel = document.getElementById(`panel-${tabId}`);
    if (targetPanel) targetPanel.classList.remove('hidden');

    document.querySelectorAll('#exhibition-show-page .ex-tab-btn').forEach(btn => btn.classList.remove('active'));
    if (el) el.classList.add('active');

    if (updateHash) {
      window.location.hash = `tab-${tabId}`;
    }
  }

  function openExhibitionTabFromHash() {
    const hash = window.location.hash.replace('#', '');
    if (!hash.startsWith('tab-')) return;

    const tabId = hash.replace('tab-', '');
    const tabButton = document.getElementById(`tab-${tabId}`);
    if (tabButton) switchExhibitionTab(tabId, tabButton, false);
  }

  function toggleExhibitionFaq(idx) {
    const answer = document.getElementById(`faq-answer-${idx}`);
    const chevron = document.getElementById(`faq-chevron-${idx}`);
    if (!answer || !chevron) return;

    const isHidden = answer.classList.contains('hidden');
    answer.classList.toggle('hidden', !isHidden);
    chevron.classList.toggle('rotate-180', isHidden);
  }

  function shareExhibition() {
    if (navigator.share) {
      navigator.share({ title: @json($title ?? 'Exhibition'), url: window.location.href }).catch(() => {});
    } else if (navigator.clipboard) {
      navigator.clipboard.writeText(window.location.href);
      alert('Event link copied to clipboard!');
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    openExhibitionTabFromHash();

    const statRow = document.getElementById('ex-stat-row');
    document.querySelectorAll('[data-stat-scroll]').forEach(btn => {
      btn.addEventListener('click', () => {
        if (!statRow) return;
        const delta = btn.dataset.statScroll === 'next' ? 220 : -220;
        statRow.scrollBy({ left: delta, behavior: 'smooth' });
      });
    });
  });

  window.addEventListener('hashchange', openExhibitionTabFromHash);
</script>
@endpush
