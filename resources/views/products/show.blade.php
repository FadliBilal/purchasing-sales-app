<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Nama Produk') }} : {{ $product->name_product }}</h3>
                            <p></p>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Harga') }} : {{ $product->price }}</h3>
                            <p></p>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Stok') }} : {{ $product->stock }}</h3>
                            <p></p>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Supplier') }} : {{ $product->supplier->name_supplier ?? '-' }}</h3>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('products.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Back') }}</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Edit Product') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
