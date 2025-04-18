<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-600 text-white rounded shadow">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST" id="sales-form">
                        @csrf

                        {{-- Master Info --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="customer-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Customer
                                </label>
                                <select name="customer_id" id="customer-select" required
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700
                                           text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600
                                           focus:ring focus:ring-blue-500">
                                    <option value="">{{ __('-- Pilih Customer --') }}</option>
                                    @foreach($customers as $cust)
                                        <option value="{{ $cust->id }}"
                                            {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                            {{ $cust->name_customer }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Sales Date</label>
                                <p class="mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    {{ date('Y-m-d') }}
                                </p>
                                <input type="hidden" name="sales_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        {{-- Items Section --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Items</h3>
                            <table class="w-full table-auto text-sm text-left">
                                <thead>
                                    <tr class="border-b border-gray-600 text-gray-600 dark:text-gray-300">
                                        <th class="py-2 px-2">Produk</th>
                                        <th class="py-2 px-2">Qty</th>
                                        <th class="py-2 px-2">Harga</th>
                                        <th class="py-2 px-2">Subtotal</th>
                                        <th class="py-2 px-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="items-body">
                                    <tr class="item-row border-b border-gray-600">
                                        <td class="px-2 py-1">
                                            <select name="items[0][product_id]" required
                                                class="product-select w-full px-2 py-1 rounded bg-gray-100 dark:bg-gray-700
                                                       text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600">
                                                <option value="">{{ __('-- Pilih Produk --') }}</option>
                                                @foreach ($products as $prod)
                                                    <option value="{{ $prod->id }}"
                                                        data-price="{{ $prod->price }}"
                                                        data-stock="{{ $prod->stock }}">
                                                        {{ $prod->name_product }} (Stok: {{ $prod->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-2 py-1">
                                            <input type="number" name="items[0][quantity]" min="1" value="1"
                                                class="qty-input w-full px-2 py-1 rounded bg-gray-100 dark:bg-gray-700
                                                       text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600">
                                        </td>
                                        <td class="px-2 py-1">
                                            <input type="text" name="items[0][price]" readonly
                                                class="price-input w-full px-2 py-1 rounded bg-gray-100 dark:bg-gray-700
                                                       text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600">
                                        </td>
                                        <td class="px-2 py-1">
                                            <span class="subtotal-span">0</span>
                                        </td>
                                        <td class="px-2 py-1 text-center">
                                            <button type="button" class="remove-row text-red-500 hover:text-red-700">×</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" id="add-row"
                                class="mt-2 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded shadow text-sm">
                                + Tambah Baris
                            </button>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
                                Simpan Sale
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Script (dinamis item rows) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let rowIndex = 1;
            const itemsBody = document.getElementById('items-body');
            const addRowBtn = document.getElementById('add-row');

            function updateSubtotal(row) {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                row.querySelector('.subtotal-span').textContent = (qty * price).toLocaleString();
            }

            function bindRowEvents(row) {
                const prodSelect = row.querySelector('.product-select');
                const qtyInput = row.querySelector('.qty-input');

                prodSelect.addEventListener('change', () => {
                    const opt = prodSelect.selectedOptions[0];
                    const price = parseFloat(opt.dataset.price) || 0;
                    const stock = parseInt(opt.dataset.stock) || 0;

                    row.querySelector('.price-input').value = price;
                    if (qtyInput.value > stock) {
                        alert(`Stok produk ini hanya ${stock}.`);
                        qtyInput.value = stock;
                    }
                    updateSubtotal(row);
                });

                qtyInput.addEventListener('input', () => {
                    const opt = prodSelect.selectedOptions[0];
                    const stock = parseInt(opt?.dataset.stock) || 0;
                    if (qtyInput.value > stock) {
                        alert(`Stok produk ini hanya ${stock}.`);
                        qtyInput.value = stock;
                    }
                    updateSubtotal(row);
                });

                row.querySelector('.remove-row').addEventListener('click', () => {
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                    } else {
                        alert('Minimal satu item wajib diisi.');
                    }
                });
            }

            // initial bind
            bindRowEvents(itemsBody.querySelector('.item-row'));

            // add row
            addRowBtn.addEventListener('click', () => {
                const template = itemsBody.querySelector('.item-row');
                const newRow = template.cloneNode(true);

                newRow.querySelectorAll('select, input').forEach(el => {
                    el.name = el.name.replace(/\[\d+\]/, `[${rowIndex}]`);
                    if (el.tagName === 'SELECT') el.selectedIndex = 0;
                    else if (el.type === 'number') el.value = 1;
                    else el.value = '';
                });
                newRow.querySelector('.subtotal-span').textContent = '0';

                itemsBody.appendChild(newRow);
                bindRowEvents(newRow);
                rowIndex++;
            });
        });
    </script>
</x-app-layout>
