<script>
    (() => {
        const badge = document.getElementById('company-notification-badge');
        if (!badge) {
            return;
        }

        const unreadCountUrl = @json(route('company.notifications.unread-count'));

        const applyUnreadCount = (count) => {
            const safeCount = Math.max(0, Number.parseInt(count, 10) || 0);

            if (safeCount > 0) {
                badge.textContent = safeCount > 99 ? '99+' : String(safeCount);
                badge.dataset.unreadCount = String(safeCount);
                badge.classList.remove('hidden');
                return;
            }

            badge.dataset.unreadCount = '0';
            badge.classList.add('hidden');
        };

        const refreshUnreadCount = async () => {
            try {
                const response = await fetch(unreadCountUrl, {
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                applyUnreadCount(data.count ?? 0);
            } catch (error) {
                // Ignore network errors and keep the server-rendered badge state.
            }
        };

        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                refreshUnreadCount();
            }
        });

        if (document.referrer.includes('/company/notifications')) {
            refreshUnreadCount();
        }
    })();
</script>
