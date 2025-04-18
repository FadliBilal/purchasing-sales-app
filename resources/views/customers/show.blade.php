<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Nama Customer') }} : {{ $customer->name_customer }}</h3>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Telepon') }} : {{ $customer->phone }}</h3>
                        </div>
                        <div>
                            <h3 class="font-medium text-lg">{{ __('Alamat') }} : {{ $customer->address }}</h3>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('customers.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Back') }}</a>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">{{ __('Edit Customer') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
