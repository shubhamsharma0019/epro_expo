@php
    $signups = $visitor_overview['signups'] ?? [];
    $chartId = $chartId ?? 'admin-visitor-signups-chart';
@endphp

<div class="relative mt-6 h-52 w-full sm:h-56">
    <canvas id="{{ $chartId }}" role="img" aria-label="Visitor signups over the last seven days"></canvas>
</div>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const canvas = document.getElementById(@json($chartId));

            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            const labels = @json(collect($signups)->pluck('label')->values());
            const values = @json(collect($signups)->pluck('value')->values());
            const context = canvas.getContext('2d');
            const fillGradient = context.createLinearGradient(0, 0, 0, 220);
            fillGradient.addColorStop(0, 'rgba(99, 102, 241, 0.32)');
            fillGradient.addColorStop(1, 'rgba(55, 35, 219, 0.04)');

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'New signups',
                        data: values,
                        borderColor: '#3723db',
                        backgroundColor: fillGradient,
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#3723db',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0B132C',
                            padding: 10,
                            callbacks: {
                                label: (context) => {
                                    const count = context.parsed.y ?? 0;
                                    return `${count} signup${count === 1 ? '' : 's'}`;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11 },
                                color: '#6b7280',
                                maxRotation: 0,
                                autoSkip: true,
                                maxTicksLimit: 7,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: { size: 11 },
                                color: '#6b7280',
                            },
                            grid: { color: 'rgba(229, 231, 235, 0.85)' },
                        },
                    },
                },
            });
        });
    </script>
@endpush
