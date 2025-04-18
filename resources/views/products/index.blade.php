<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inventory Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    + Tambah Produk
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="w-full table-auto text-sm text-left text-gray-800 dark:text-gray-100">
                    <thead>
                        <tr class="border-b border-gray-600 text-gray-700 dark:text-gray-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Stok</th>
                            <th class="py-3 px-4">Supplier</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b border-gray-700 hover:bg-gray-700/30">
                                <td class="py-2 px-4">{{ $product->name_product }}</td>
                                <td class="py-2 px-4">Rp {{ number_format($product->price,0,',','.') }}</td>
                                <td class="py-2 px-4">{{ $product->stock }}</td>
                                <td class="py-2 px-4">{{ $product->supplier->name_supplier ?? '-' }}</td>
                                <td class="py-2 px-4">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('products.show',$product->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs shadow">Details</a>
                                        <a href="{{ route('products.edit',$product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs shadow">Edit</a>
                                        <form action="{{ route('products.destroy',$product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-400">Belum ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
