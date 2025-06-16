<x-app-layout>
    {{-- Memuat library Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Gaya kustom untuk animasi grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            transition: all 0.5s ease-in-out;
        }

        .dashboard-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            transition: all 0.5s ease-in-out;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        /* Saat ada kartu yang diperbesar */
        .dashboard-grid.has-expanded-card .dashboard-card:not(.expanded) {
            transform: scale(0.95);
            opacity: 0.6;
            filter: blur(2px);
        }

        .dashboard-card.expanded {
            grid-column: 1 / -1; /* Membentang selebar grid */
            grid-row: 1; /* Pindah ke baris pertama */
            transform: scale(1);
            opacity: 1;
            filter: none;
            cursor: default;
            order: -1; /* Pindahkan ke urutan paling atas */
        }
        
        .card-content-normal, .card-content-expanded {
            transition: opacity 0.5s ease-in-out, visibility 0.5s;
        }

        .card-content-expanded {
            opacity: 0;
            visibility: hidden;
            position: absolute;
            max-height: 0;
        }

        .dashboard-card.expanded .card-content-normal {
            opacity: 0;
            visibility: hidden;
            max-height: 0;
        }

        .dashboard-card.expanded .card-content-expanded {
            opacity: 1;
            visibility: visible;
            position: static;
            max-height: none;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="dashboard-grid" class="dashboard-grid">

                <!-- Kartu 1: Pertumbuhan Pengguna -->
                <div class="dashboard-card" onclick="expandCard(this)">
                    <div class="p-6">
                        <div class="card-content-normal">
                            <h3 class="font-semibold text-lg text-gray-900">Pertumbuhan Pengguna</h3>
                            <p class="text-sm text-gray-500 mb-4">30 Hari Terakhir</p>
                            <div class="relative" style="height: 200px;">
                                <canvas id="userGrowthChart"></canvas>
                            </div>
                        </div>
                        <div class="card-content-expanded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900">Detail Pertumbuhan Pengguna</h3>
                                    <p class="text-gray-600">Analisis tren pendaftaran pengguna baru.</p>
                                </div>
                                <button onclick="collapseCards(event)" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                            <div class="mt-4" style="height: 300px;">
                                <canvas id="userGrowthChartExpanded"></canvas>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800">Gagasan & Wawasan</h4>
                                <p class="text-gray-600 mt-2">Terjadi lonjakan pendaftaran pada tanggal tertentu. Ini bisa jadi karena promosi atau event khusus. Pertimbangkan untuk menganalisis korelasi dengan aktivitas marketing.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu 2: Buku Paling Favorit -->
                <div class="dashboard-card" onclick="expandCard(this)">
                    <div class="p-6">
                         <div class="card-content-normal">
                            <h3 class="font-semibold text-lg text-gray-900">Buku Paling Favorit</h3>
                             <p class="text-sm text-gray-500 mb-4">Top 5 Buku</p>
                            <div class="relative" style="height: 200px;">
                                <canvas id="favoriteBooksChart"></canvas>
                            </div>
                        </div>
                        <div class="card-content-expanded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900">Statistik Favorit</h3>
                                    <p class="text-gray-600">Buku yang paling disukai oleh pengguna.</p>
                                </div>
                                <button onclick="collapseCards(event)" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                             <div class="mt-4" style="height: 300px;">
                                <canvas id="favoriteBooksChartExpanded"></canvas>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800">Gagasan & Wawasan</h4>
                                <p class="text-gray-600 mt-2">Buku dengan genre "Pengembangan Diri" mendominasi. Ini menandakan minat pasar yang tinggi pada genre tersebut. Pertimbangkan untuk menambah koleksi buku serupa atau membuat promosi khusus.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu 3: Volume Transaksi -->
                <div class="dashboard-card" onclick="expandCard(this)">
                    <div class="p-6">
                         <div class="card-content-normal">
                            <h3 class="font-semibold text-lg text-gray-900">Volume Transaksi</h3>
                             <p class="text-sm text-gray-500 mb-4">30 Hari Terakhir</p>
                            <div class="relative" style="height: 200px;">
                                <canvas id="transactionVolumeChart"></canvas>
                            </div>
                        </div>
                        <div class="card-content-expanded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900">Analisis Transaksi</h3>
                                    <p class="text-gray-600">Tren pembelian buku oleh pengguna.</p>
                                </div>
                                <button onclick="collapseCards(event)" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                             <div class="mt-4" style="height: 300px;">
                                <canvas id="transactionVolumeChartExpanded"></canvas>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800">Gagasan & Wawasan</h4>
                                <p class="text-gray-600 mt-2">Pola transaksi cenderung meningkat di akhir pekan. Manfaatkan momentum ini untuk memberikan penawaran 'Weekend Deals' untuk meningkatkan konversi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kartu 4: Distribusi Kategori -->
                <div class="dashboard-card" onclick="expandCard(this)">
                    <div class="p-6">
                         <div class="card-content-normal">
                            <h3 class="font-semibold text-lg text-gray-900">Distribusi Kategori</h3>
                            <div class="relative mx-auto" style="height:180px; width:180px;">
                                <canvas id="categoryDistributionChart"></canvas>
                            </div>
                        </div>
                         <div class="card-content-expanded">
                             <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900">Distribusi Kategori Buku</h3>
                                    <p class="text-gray-600">Komposisi koleksi buku Anda.</p>
                                </div>
                                <button onclick="collapseCards(event)" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                             <div class="mt-4 flex justify-center" style="height: 300px;">
                                <canvas id="categoryDistributionChartExpanded"></canvas>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800">Gagasan & Wawasan</h4>
                                <p class="text-gray-600 mt-2">Kategori "Filsafat" memiliki porsi yang signifikan. Ini menunjukkan niche audiens yang kuat. Namun, kategori "Sains & Teknologi" masih sedikit, ini adalah peluang untuk ekspansi koleksi.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu 5: Status Top-up -->
                <div class="dashboard-card" onclick="expandCard(this)">
                    <div class="p-6">
                         <div class="card-content-normal">
                            <h3 class="font-semibold text-lg text-gray-900">Status Permintaan Top-up</h3>
                            <div class="relative mx-auto" style="height:180px; width:180px;">
                                <canvas id="topupStatusChart"></canvas>
                            </div>
                        </div>
                        <div class="card-content-expanded">
                             <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-2xl text-gray-900">Status Permintaan Top-up</h3>
                                    <p class="text-gray-600">Ringkasan status permintaan top-up saldo.</p>
                                </div>
                                <button onclick="collapseCards(event)" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                             <div class="mt-4 flex justify-center" style="height: 300px;">
                                <canvas id="topupStatusChartExpanded"></canvas>
                            </div>
                             <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800">Gagasan & Wawasan</h4>
                                <p class="text-gray-600 mt-2">Jumlah permintaan yang 'ditolak' cukup rendah, ini bagus. Namun, masih ada permintaan 'tertunda' yang perlu segera diproses untuk menjaga kepuasan pengguna.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- INI ADALAH KODE JAVASCRIPT YANG BENAR UNTUK FILE BLADE --}}
    <script>
        const grid = document.getElementById('dashboard-grid');
        let chartInstances = {};
        const apiEndpoint = "{{ route('admin.api.dashboardStats') }}"; // <- Mendapatkan URL API dari Laravel

        const chartConfigs = {
            // Konfigurasi dasar untuk setiap grafik (tanpa data)
            userGrowthChart: {
                type: 'line',
                options: (isExpanded) => ({ responsive: true, maintainAspectRatio: false, plugins: { legend: { display: isExpanded } }, scales: { y: { beginAtZero: true }, x: { display: isExpanded } } })
            },
            favoriteBooksChart: {
                type: 'bar',
                options: (isExpanded) => ({ indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { display: isExpanded } } })
            },
            transactionVolumeChart: {
                type: 'line',
                options: (isExpanded) => ({ responsive: true, maintainAspectRatio: false, plugins: { legend: { display: isExpanded } }, scales: { y: { beginAtZero: true }, x: { display: isExpanded } } })
            },
            categoryDistributionChart: {
                type: 'doughnut',
                options: (isExpanded) => ({ responsive: true, maintainAspectRatio: false, plugins: { legend: { display: isExpanded, position: 'right' } } })
            },
            topupStatusChart: {
                type: 'pie',
                options: (isExpanded) => ({ responsive: true, maintainAspectRatio: false, plugins: { legend: { display: isExpanded, position: 'right' } } })
            }
        };
        
        // Fungsi untuk memuat data dan merender semua grafik
        async function loadAndRenderCharts() {
            try {
                const response = await fetch(apiEndpoint);
                if (!response.ok) {
                    throw new Error('Gagal mengambil data statistik');
                }
                const stats = await response.json();

                // Render setiap grafik dengan data dari API
                renderChart('userGrowthChart', false, {
                    labels: stats.userGrowth.labels,
                    datasets: [{ label: 'Pengguna Baru', data: stats.userGrowth.data, borderColor: '#28738B', backgroundColor: 'rgba(40, 115, 139, 0.1)', fill: true, tension: 0.4 }]
                });
                renderChart('favoriteBooksChart', false, {
                    labels: stats.favoriteBooks.labels,
                    datasets: [{ label: 'Jumlah Favorit', data: stats.favoriteBooks.data, backgroundColor: ['#28738B', '#F3A26D', '#FF7601', '#6b7280', '#a8a29e'] }]
                });
                renderChart('transactionVolumeChart', false, {
                    labels: stats.transactionVolume.labels,
                    datasets: [{ label: 'Jumlah Transaksi', data: stats.transactionVolume.data, borderColor: '#FF7601', backgroundColor: 'rgba(255, 118, 1, 0.1)', fill: true, tension: 0.4 }]
                });
                renderChart('categoryDistributionChart', false, {
                    labels: stats.categoryDistribution.labels,
                    datasets: [{ label: 'Distribusi', data: stats.categoryDistribution.data, backgroundColor: ['#28738B', '#F3A26D', '#FF7601', '#6b7280', '#a8a29e'] }]
                });
                renderChart('topupStatusChart', false, {
                    labels: stats.topupStatus.labels,
                    datasets: [{ label: 'Status', data: stats.topupStatus.data, backgroundColor: ['#10b981', '#f59e0b', '#ef4444'] }]
                });

                // Simpan data untuk digunakan saat kartu diperbesar
                grid.dataset.chartData = JSON.stringify(stats);

            } catch (error) {
                console.error("Error memuat data chart:", error);
            }
        }

        function expandCard(cardElement) {
            if (cardElement.classList.contains('expanded')) return;
            const expandedCard = grid.querySelector('.expanded');
            if (expandedCard) expandedCard.classList.remove('expanded');
            
            grid.classList.add('has-expanded-card');
            cardElement.classList.add('expanded');
            
            const canvasId = cardElement.querySelector('canvas').id;
            const expandedCanvasId = canvasId + 'Expanded';
            if(chartInstances[expandedCanvasId]) chartInstances[expandedCanvasId].destroy();

            const stats = JSON.parse(grid.dataset.chartData);
            let dataForChart;
            switch (canvasId) {
                case 'userGrowthChart': dataForChart = { labels: stats.userGrowth.labels, datasets: [{ label: 'Pengguna Baru', data: stats.userGrowth.data, borderColor: '#28738B', backgroundColor: 'rgba(40, 115, 139, 0.1)', fill: true, tension: 0.4 }] }; break;
                case 'favoriteBooksChart': dataForChart = { labels: stats.favoriteBooks.labels, datasets: [{ label: 'Jumlah Favorit', data: stats.favoriteBooks.data, backgroundColor: ['#28738B', '#F3A26D', '#FF7601', '#6b7280', '#a8a29e'] }] }; break;
                case 'transactionVolumeChart': dataForChart = { labels: stats.transactionVolume.labels, datasets: [{ label: 'Jumlah Transaksi', data: stats.transactionVolume.data, borderColor: '#FF7601', backgroundColor: 'rgba(255, 118, 1, 0.1)', fill: true, tension: 0.4 }] }; break;
                case 'categoryDistributionChart': dataForChart = { labels: stats.categoryDistribution.labels, datasets: [{ label: 'Distribusi', data: stats.categoryDistribution.data, backgroundColor: ['#28738B', '#F3A26D', '#FF7601', '#6b7280', '#a8a29e'] }] }; break;
                case 'topupStatusChart': dataForChart = { labels: stats.topupStatus.labels, datasets: [{ label: 'Status', data: stats.topupStatus.data, backgroundColor: ['#10b981', '#f59e0b', '#ef4444'] }] }; break;
            }
            renderChart(expandedCanvasId, true, dataForChart);
        }

        function collapseCards(event) {
            event.stopPropagation();
            const expandedCard = grid.querySelector('.expanded');
            if (expandedCard) {
                expandedCard.classList.remove('expanded');
                grid.classList.remove('has-expanded-card');
            }
        }
        
        function renderChart(canvasId, isExpanded = false, data) {
            const ctx = document.getElementById(canvasId)?.getContext('2d');
            if (!ctx) return;
            const baseId = canvasId.replace('Expanded', '');
            const config = chartConfigs[baseId];
            
            if(config) {
                if(chartInstances[canvasId]) chartInstances[canvasId].destroy();
                chartInstances[canvasId] = new Chart(ctx, {
                    type: config.type,
                    data: data,
                    options: config.options(isExpanded)
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
           loadAndRenderCharts();
        });
    </script>

</x-app-layout>
