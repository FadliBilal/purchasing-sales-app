<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Purchases') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-500 text-white rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-end mb-4">
                <a href="{{ route('purchases.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    + Tambah Purchase
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="w-full table-auto text-sm text-left text-gray-800 dark:text-gray-100">
                    <thead>
                        <tr class="border-b border-gray-600 text-gray-300 uppercase text-xs tracking-wider">
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Supplier</th>
                            <th class="py-3 px-4">Total Amount</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr class="border-b border-gray-700 hover:bg-gray-700/30">
                                <td class="py-2 px-4">{{ $purchase->purchase_date->format('Y-m-d') }}</td>
                                <td class="py-2 px-4">{{ $purchase->supplier->name_supplier }}</td>
                                <td class="py-2 px-4">Rp {{ number_format($purchase->items->sum(fn($i)=> $i->quantity * $i->price),0,',','.') }}</td>
                                <td class="py-2 px-4">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('purchases.show',$purchase->id) }}"
                                           class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-xs shadow">
                                            Details
                                        </a>
                                        <a href="{{ route('purchases.edit',$purchase->id) }}"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs shadow">
                                            Edit
                                        </a>
                                        <form action="{{ route('purchases.destroy',$purchase->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus purchase ini?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs shadow">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-400">
                                    Belum ada data purchase.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
