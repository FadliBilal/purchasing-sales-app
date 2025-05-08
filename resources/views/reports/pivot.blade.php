<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Pivot') }}
        </h2>
    </x-slot>

    <!-- CSS untuk Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-100">
                <canvas id="pivotChart" width="400" height="200"></canvas>

                <div class="mt-4">
                    <a href="{{ route('report.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Kembali ke Laporan
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        const pivotData = @json($data);

        // Menyiapkan data untuk chart
        const products = pivotData.map(item => item.product);
        const subtotals = pivotData.map(item => item.subtotal);

        const ctx = document.getElementById('pivotChart').getContext('2d');
        const pivotChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: products,  
                datasets: [{
                    label: 'Subtotal',
                    data: subtotals,  
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',  
                    borderColor: 'rgba(75, 192, 192, 1)',  
                    borderWidth: 1  
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,  
                            maxRotation: 90,  
                            minRotation: 90
                        }
                    },
                    y: {
                        beginAtZero: true  
                    }
                }
            }
        });
    </script>
</x-app-layout>
