<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Customer') }}
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

                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Nama Customer</label>
                                <input type="text" name="name_customer" value="{{ old('name_customer') }}"
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700
                                           text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600
                                           focus:outline-none focus:ring focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700
                                           text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600
                                           focus:outline-none focus:ring focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Alamat</label>
                                <textarea name="address" rows="3"
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700
                                           text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600
                                           focus:outline-none focus:ring focus:ring-blue-500">{{ old('address') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
