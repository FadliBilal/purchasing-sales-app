<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-500 text-white rounded shadow">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Nama Produk</label>
                                <input type="text" name="name_product" value="{{ old('name_product') }}"
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Harga</label>
                                <input type="number" name="price" value="{{ old('price') }}"
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Supplier</label>
                                <select name="supplier_id" required
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 focus:outline-none">
                                    <option value="">{{ __('-- Pilih Supplier --') }}</option>
                                    @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }}" {{ old('supplier_id')==$sup->id?'selected':'' }}>
                                            {{ $sup->name_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6 space-x-2">
                            <a href="{{ route('suppliers.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Back') }}</a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Save Product') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
