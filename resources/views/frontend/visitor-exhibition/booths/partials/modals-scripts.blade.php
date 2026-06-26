<!-- Video Player Modal -->
<div id="media-video-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="relative w-full max-w-[800px] rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-[#E7EAF3] pb-4">
            <h3 id="media-video-title" class="truncate pr-4 text-[18px] font-bold text-[#071044]">Video Player</h3>
            <button onclick="closeMediaVideoModal()" class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-[#F4F0FF] text-[#5b2eff] transition-colors hover:bg-[#EADCFD]">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div id="media-video-container" class="mt-4 flex items-center justify-center overflow-hidden rounded-xl bg-black"></div>
    </div>
</div>

<div id="media-image-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="relative w-full max-w-[800px] rounded-2xl border border-[#E7EAF3] bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-[#E7EAF3] pb-4">
            <h3 id="media-image-title" class="truncate pr-4 text-[18px] font-bold text-[#071044]">Image Viewer</h3>
            <button onclick="closeMediaImageModal()" class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-[#F4F0FF] text-[#5b2eff] transition-colors hover:bg-[#EADCFD]">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mt-4 flex justify-center overflow-hidden rounded-xl bg-[#FBFAFF] p-2">
            <img id="media-image-display" src="" alt="View Image" class="max-h-[70vh] rounded-lg object-contain">
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('exhibition-api.js') }}"></script>
<script>
    function openVideoModal(url, title) {
        const modal = document.getElementById('media-video-modal');
        const modalTitle = document.getElementById('media-video-title');
        const container = document.getElementById('media-video-container');
        if (!modal || !container) return;

        modalTitle.textContent = title || 'Video Player';

        let html = '';
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let videoId = '';
            if (url.includes('youtu.be/')) {
                videoId = url.split('youtu.be/')[1].split(/[?#]/)[0];
            } else if (url.includes('v=')) {
                videoId = url.split('v=')[1].split('&')[0];
            } else if (url.includes('/embed/')) {
                videoId = url.split('/embed/')[1].split(/[?#]/)[0];
            }
            html = `<iframe class="w-full aspect-video rounded-lg" style="aspect-ratio: 16 / 9; height: auto; max-height: 450px;" src="https://www.youtube.com/embed/${videoId}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        } else if (url.includes('vimeo.com')) {
            let videoId = url.split('vimeo.com/')[1].split(/[?#]/)[0];
            html = `<iframe class="w-full aspect-video rounded-lg" style="aspect-ratio: 16 / 9; height: auto; max-height: 450px;" src="https://player.vimeo.com/video/${videoId}?autoplay=1" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
        } else if (url.endsWith('.mp4') || url.endsWith('.webm') || url.endsWith('.ogg') || url.includes('mov_bbb.mp4')) {
            html = `<video class="w-full rounded-lg" style="max-height: 450px;" controls autoplay><source src="${url}">Your browser does not support the video tag.</video>`;
        } else {
            html = `
                <div class="flex w-full flex-col items-center justify-center bg-white p-6">
                    <video class="mb-4 w-full rounded-lg" style="max-height: 350px;" controls autoplay><source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"></video>
                    <p class="mb-4 text-center text-[14px] font-medium text-[#5A6480]">Playing product overview. You can also view the external resource directly:</p>
                    <a href="${url}" target="_blank" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#5b2eff] px-6 text-[14px] font-bold text-white shadow-sm transition-colors hover:bg-[#4310d8]">Visit Website <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i></a>
                </div>
            `;
        }

        container.innerHTML = html;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMediaVideoModal() {
        const modal = document.getElementById('media-video-modal');
        const container = document.getElementById('media-video-container');
        if (modal) modal.classList.add('hidden');
        if (container) container.innerHTML = '';
        document.body.classList.remove('overflow-hidden');
    }

    function openImageModal(url, title) {
        const modal = document.getElementById('media-image-modal');
        const modalTitle = document.getElementById('media-image-title');
        const imgElement = document.getElementById('media-image-display');
        if (!modal || !imgElement) return;

        modalTitle.textContent = title || 'Image Viewer';
        imgElement.src = url;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeMediaImageModal() {
        const modal = document.getElementById('media-image-modal');
        const imgElement = document.getElementById('media-image-display');
        if (modal) modal.classList.add('hidden');
        if (imgElement) imgElement.src = '';
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        ['media-video-modal', 'media-image-modal'].forEach((id) => {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    id === 'media-video-modal' ? closeMediaVideoModal() : closeMediaImageModal();
                }
            });
        });

        const shareBtn = document.getElementById('share-booth-btn');
        if (shareBtn) {
            shareBtn.addEventListener('click', async () => {
                const shareUrl = shareBtn.dataset.shareUrl || window.location.href;
                const shareData = { title: document.title, url: shareUrl };
                if (navigator.share) {
                    try { await navigator.share(shareData); return; } catch (_) {}
                }
                try {
                    await navigator.clipboard.writeText(shareUrl);
                    shareBtn.innerHTML = '<i class="ph ph-check"></i><span class="hidden sm:inline">Link Copied</span>';
                    setTimeout(() => {
                        shareBtn.innerHTML = '<i class="ph ph-share-network"></i><span class="hidden sm:inline">Share Booth</span>';
                    }, 1800);
                } catch (_) {
                    window.prompt('Copy booth link:', shareUrl);
                }
            });
        }

        const saveBoothBtn = document.getElementById('save-booth-btn');
        const bookingId = localStorage.getItem('lastBookingId') || '{{ $visitorBookingId ?? '' }}';
        const targetId = 'booking-{{ $booking->id ?? '' }}';

        if (saveBoothBtn && bookingId && targetId !== 'booking-') {
            let isBookmarked = false;
            const savedClasses = 'inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-emerald-100 bg-emerald-50 px-4 text-[13px] font-bold text-emerald-700';
            const defaultClasses = 'inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-[#E7EAF3] bg-white px-4 text-[13px] font-bold text-[#071044] hover:bg-[#F8F7FF]';

            ExhibitionAPI.getBookmarks(bookingId).then((bookmarks) => {
                isBookmarked = bookmarks.some((b) => b.bookmarkable_type === 'exhibitor' && b.bookmarkable_id == targetId);
                updateBtnUI(isBookmarked);
            }).catch(() => {});

            saveBoothBtn.addEventListener('click', async (e) => {
                e.preventDefault();
                saveBoothBtn.disabled = true;
                try {
                    const res = await ExhibitionAPI.toggleBookmark(bookingId, 'exhibitor', targetId);
                    if (res) {
                        isBookmarked = res.status === 'added';
                        updateBtnUI(isBookmarked);
                    }
                } finally {
                    saveBoothBtn.disabled = false;
                }
            });

            function updateBtnUI(saved) {
                saveBoothBtn.className = saved ? savedClasses : defaultClasses;
                saveBoothBtn.innerHTML = saved
                    ? '<i class="ph ph-heart-fill"></i><span class="hidden sm:inline">Saved</span>'
                    : '<i class="ph ph-heart"></i><span class="hidden sm:inline">Add to Favorite</span>';
            }
        }

        const navLinks = Array.from(document.querySelectorAll('.booth-home-nav a[href^="#"]'));
        const setActiveNav = (hash) => {
            navLinks.forEach((link) => {
                link.classList.toggle('is-active', link.getAttribute('href') === hash);
            });
        };
        navLinks.forEach((link) => {
            link.addEventListener('click', () => setActiveNav(link.getAttribute('href')));
        });
        if (window.location.hash) {
            setActiveNav(window.location.hash);
        }
    });
</script>
@endpush
