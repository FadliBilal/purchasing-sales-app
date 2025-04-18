<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Purchase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <div>
                        <strong class="text-gray-300">Tanggal : {{ $purchase->purchase_date->format('Y-m-d') }}</strong>
                    </div>
                    <div>
                        <strong class="text-gray-300">Supplier : {{ $purchase->supplier->name_supplier }}</strong>
                    </div>
                    <div>
                        <strong class="text-gray-300">Items yang dibeli : </strong>
                        <table class="w-full mt-2 table-auto text-sm text-gray-800 dark:text-gray-100">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="py-2 px-2">Produk</th>
                                    <th class="py-2 px-2">Qty</th>
                                    <th class="py-2 px-2">Harga</th>
                                    <th class="py-2 px-2">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->items as $item)
                                    <tr class="border-b border-gray-700">
                                        <td class="py-2 px-2">{{ $item->product->name_product }}</td>
                                        <td class="py-2 px-2">{{ $item->quantity }}</td>
                                        <td class="py-2 px-2">Rp {{ number_format($item->price,0,',','.') }}</td>
                                        <td class="py-2 px-2">Rp {{ number_format($item->quantity * $item->price,0,',','.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <strong class="text-gray-300">Total : Rp {{ number_format($purchase->items->sum(fn($i)=> $i->quantity * $i->price),0,',','.') }}</strong>
                    </div>
                    <div class="pt-6 flex justify-end space-x-2">
                        <a href="{{ route('purchases.index') }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded shadow">
                            {{ __('Kembali') }}
                        </a>
                        <a href="{{ route('purchases.edit',$purchase->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                            {{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
