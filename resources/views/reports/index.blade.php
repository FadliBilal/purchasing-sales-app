<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Penjualan & Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Filter Tanggal --}}
            <div class="bg-white dark:bg-white p-6 rounded shadow">
                <form method="GET" action="{{ route('report.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label for="start_date" class="text-gray-100">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $startDate) }}" class="rounded-md dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label for="end_date" class="text-gray-100">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $endDate) }}" class="rounded-md dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
                            Filter
                        </button>
                        <button id="resetFilter" class="bg-blue-600 text-black px-4 py-2 rounded-md hover:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            {{ __('Reset Filter') }}
                        </button>
                        <a href="{{ route('report.pivot') }}" class="bg-yellow-600 text-black px-4 py-2 rounded hover:bg-yellow-700">
                            Menuju Pivot
                        </a>
                        <a href="{{ route('report.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                           class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700 ml-2">
                            Export Excel
                        </a>
                    </div>
                </form>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow text-white">
                    <h3 class="text-lg font-bold mb-2">Total Penjualan</h3>
                    <p class="text-2xl">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow text-white">
                    <h3 class="text-lg font-bold mb-2">Total Pembelian</h3>
                    <p class="text-2xl">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Tabel Penjualan --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow text-white">
                <h3 class="text-lg font-bold mb-4">Data Penjualan</h3>
                <div class="overflow-auto">
                    <table class="min-w-full text-left">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Customer</th>
                                <th class="p-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                                <tr class="border-b border-gray-600">
                                    <td class="p-2">{{ $sale->sales_date }}</td>
                                    <td class="p-2">{{ $sale->customer->name_customer ?? '-' }}</td>
                                    <td class="p-2">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-2 text-center">Tidak ada data penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Pembelian --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow text-white">
                <h3 class="text-lg font-bold mb-4">Data Pembelian</h3>
                <div class="overflow-auto">
                    <table class="min-w-full text-left">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Supplier</th>
                                <th class="p-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $purchase)
                                <tr class="border-b border-gray-600">
                                    <td class="p-2">{{ $purchase->purchase_date }}</td>
                                    <td class="p-2">{{ $purchase->supplier->name_supplier ?? '-' }}</td>
                                    <td class="p-2">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-2 text-center">Tidak ada data pembelian</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resetFilter').addEventListener('click', function() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
        });
    </script>
</x-app-layout>
