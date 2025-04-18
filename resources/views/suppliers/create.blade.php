<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name_supplier" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Supplier Name') }}</label>
                                <input type="text" name="name_supplier" id="name_supplier" value="{{ old('name_supplier') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Phone') }}</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Address') }}</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-gray-100" required>{{ old('address') }}</textarea>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('suppliers.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Back') }}</a>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Save Supplier') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
