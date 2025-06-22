<x-app-layout>
    {{-- Memuat library Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-[#28738B] leading-tight px-6">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- [PERUBAHAN UTAMA] Menggunakan CSS Grid untuk layout 2 kolom --}}
            {{-- Kolom kiri (2/3 lebar) berisi 4 chart, Kolom kanan (1/3 lebar) berisi 1 kartu tinggi --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- KOLOM KIRI: Berisi 4 kartu chart -->
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    <!-- Kartu 1: Pertumbuhan Pengguna -->
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="font-semibold text-lg text-gray-900">Pertumbuhan Pengguna</h3>
                        <p class="text-sm text-gray-500 mb-4">30 Hari Terakhir</p>
                        <div class="relative h-64">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>

                    <!-- Kartu 2: Volume Transaksi -->
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="font-semibold text-lg text-gray-900">Volume Transaksi</h3>
                        <p class="text-sm text-gray-500 mb-4">30 Hari Terakhir</p>
                        <div class="relative h-64">
                            <canvas id="transactionVolumeChart"></canvas>
                        </div>
                    </div>

                    <!-- Kartu 3: Distribusi Kategori -->
                    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col justify-between">
                        <h3 class="font-semibold text-lg text-gray-900">Distribusi Kategori</h3>
                        <div class="relative mx-auto my-4" style="height:180px; width:180px;">
                            <canvas id="categoryDistributionChart"></canvas>
                        </div>
                    </div>

                    <!-- Kartu 4: Status Top-up -->
                    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col justify-between">
                        <h3 class="font-semibold text-lg text-gray-900">Status Permintaan Top-up</h3>
                        <div class="relative mx-auto my-4" style="height:180px; width:180px;">
                            <canvas id="topupStatusChart"></canvas>
                        </div>
                    </div>

                </div>

                <!-- KOLOM KANAN: Berisi 1 kartu tinggi untuk Buku Terlaris -->
                <div class="lg:col-span-1">
                    {{-- h-full membuat kartu ini meregang setinggi kolom kiri --}}
                    <div class="bg-white p-6 rounded-xl shadow-md h-full flex flex-col">
                        <h3 class="font-semibold text-lg text-gray-900">Buku Terlaris</h3>
                        <p class="text-sm text-gray-500 mb-4">Top 10 berdasarkan pembelian</p>
                        
                        {{-- Container untuk daftar buku, flex-grow agar mengisi sisa ruang --}}
                        <div id="top-books-container" class="space-y-3 overflow-y-auto flex-grow">
                            {{-- Konten akan diisi oleh JavaScript --}}
                            <p class="text-center text-gray-500 pt-16">Memuat data...</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    // Objek untuk menyimpan instance Chart.js agar bisa di-destroy jika perlu
    const chartInstances = {};

    // Mendapatkan URL API dari route Laravel
    const apiEndpoint = "{{ route('admin.api.dashboardStats') }}"; 

    /**
     * Fungsi untuk merender chart
     * @param {string} canvasId - ID dari elemen canvas
     * @param {string} type - Tipe chart (line, bar, doughnut, pie)
     * @param {object} data - Objek data untuk chart
     * @param {object} options - Objek opsi untuk chart
     */
    function renderChart(canvasId, type, data, options) {
        const ctx = document.getElementById(canvasId)?.getContext('2d');
        if (!ctx) return;
        
        // Hancurkan instance chart sebelumnya jika ada untuk menghindari memory leak
        if(chartInstances[canvasId]) {
            chartInstances[canvasId].destroy();
        }

        chartInstances[canvasId] = new Chart(ctx, { type, data, options });
    }

    /**
     * Fungsi untuk merender daftar buku terlaris
     * @param {array} books - Array berisi objek buku terlaris
     */
    function renderTopBooks(books) {
        const container = document.getElementById('top-books-container');
        if (!container) return;

        // Kosongkan container
        container.innerHTML = '';

        if (!books || books.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-500 pt-16">Tidak ada data buku.</p>';
            return;
        }

        // Buat elemen daftar
        const list = document.createElement('ol');
        list.className = 'space-y-4';

        books.forEach((book, index) => {
            const listItem = document.createElement('li');
            listItem.className = 'flex items-center gap-x-4';

            // Gunakan placeholder jika cover tidak ada
            const coverUrl = book.cover ? `{{ asset('storage') }}/${book.cover}` : 'https://placehold.co/60x80/e2e8f0/94a3b8?text=N/A';
            
            listItem.innerHTML = `
                <div class="text-lg font-bold text-gray-400 w-6 text-center">${index + 1}</div>
                <img src="${coverUrl}" alt="${book.title}" class="h-16 w-12 object-cover rounded shadow-sm flex-shrink-0">
                <div class="flex-grow min-w-0">
                    <p class="font-semibold text-gray-800 truncate" title="${book.title}">${book.title}</p>
                    <p class="text-sm text-gray-500 truncate">${book.author}</p>
                </div>
                <div class="text-sm font-bold text-blue-600 flex-shrink-0">${book.purchases}x</div>
            `;
            list.appendChild(listItem);
        });

        container.appendChild(list);
    }

    /**
     * Fungsi utama untuk memuat data dan merender semua visualisasi
     */
    async function loadDashboardData() {
        try {
            const response = await fetch(apiEndpoint);
            if (!response.ok) {
                throw new Error(`Gagal mengambil data statistik: ${response.statusText}`);
            }
            const stats = await response.json();

            // 1. Render Chart Pertumbuhan Pengguna
            renderChart('userGrowthChart', 'line', 
                {
                    labels: stats.userGrowth.labels,
                    datasets: [{ 
                        label: 'Pengguna Baru', 
                        data: stats.userGrowth.data, 
                        borderColor: '#28738B', 
                        backgroundColor: 'rgba(40, 115, 139, 0.1)', 
                        fill: true, 
                        tension: 0.4 
                    }]
                },
                { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            );

            // 2. Render Chart Volume Transaksi
            renderChart('transactionVolumeChart', 'line',
                {
                    labels: stats.transactionVolume.labels,
                    datasets: [{ 
                        label: 'Jumlah Transaksi', 
                        data: stats.transactionVolume.data, 
                        borderColor: '#FF7601', 
                        backgroundColor: 'rgba(255, 118, 1, 0.1)', 
                        fill: true, 
                        tension: 0.4 
                    }]
                },
                { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
            );

            // 3. Render Chart Distribusi Kategori
            renderChart('categoryDistributionChart', 'doughnut',
                {
                    labels: stats.categoryDistribution.labels,
                    datasets: [{ 
                        data: stats.categoryDistribution.data, 
                        backgroundColor: ['#28738B', '#F3A26D', '#FF7601', '#6b7280', '#a8a29e', '#3b82f6', '#facc15'] 
                    }]
                },
                { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { 
                        legend: { 
                            display: true, 
                            position: 'bottom',   // ⬅️ Keterangan di bawah
                            align: 'start',       // ⬅️ Rata kiri
                            labels: {
                                boxWidth: 20,
                                padding: 15,
                                usePointStyle: true
                            }
                        } 
                    }
                }
            );

            
            // 4. Render Chart Status Top-up
            renderChart('topupStatusChart', 'pie',
                {
                    labels: stats.topupStatus.labels,
                    datasets: [{ 
                        data: stats.topupStatus.data, 
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'] 
                    }]
                },
                 { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true, position: 'bottom' } } }
            );

            // 5. Render Daftar Buku Terlaris
            renderTopBooks(stats.topTenBooks);

        } catch (error) {
            console.error("Error memuat data dashboard:", error);
            document.getElementById('top-books-container').innerHTML = '<p class="text-center text-red-500 pt-16">Gagal memuat data.</p>';
        }
    }

    // Jalankan fungsi saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', loadDashboardData);
</script>
</x-app-layout>