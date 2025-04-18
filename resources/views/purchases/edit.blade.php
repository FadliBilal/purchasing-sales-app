<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Purchase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-500 text-white rounded shadow">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" id="purchase-form">
                        @csrf
                        @method('PUT')

                        {{-- Master fields --}}
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Supplier</label>
                                <select name="supplier_id" id="supplier-select" required
                                    class="w-full mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                           border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-500">
                                    @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }} "
                                            {{ old('supplier_id', $purchase->supplier_id) == $sup->id ? 'selected' : '' }} >
                                            {{ $sup->name_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700 dark:text-gray-300">Purchase Date</label>
                                {{-- tampilkan tanggal asli --}}
                                <p class="mt-1 px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    {{ $purchase->purchase_date->format('Y-m-d') }}
                                </p>
                                {{-- kirim sebagai hidden --}}
                                <input type="hidden" name="purchase_date" value="{{ $purchase->purchase_date->format('Y-m-d') }}">
                            </div>
                        </div>

                        {{-- Items table --}}
                        <div class="space-y-4">
                            <h3 class="font-medium text-gray-800 dark:text-gray-200">Items</h3>
                            <table class="w-full table-auto text-sm text-gray-800 dark:text-gray-100">
                                <thead>
                                    <tr class="border-b border-gray-600">
                                        <th class="py-2 px-2">Produk</th>
                                        <th class="py-2 px-2">Qty</th>
                                        <th class="py-2 px-2">Harga</th>
                                        <th class="py-2 px-2">Subtotal</th>
                                        <th class="py-2 px-2">#</th>
                                    </tr>
                                </thead>
                                <tbody id="items-body">
                                    @foreach(old('items', $purchase->items->toArray()) as $i => $item)
                                        <tr class="item-row border-b border-gray-600">
                                            <td class="px-2 py-1">
                                                <select name="items[{{ $i }}][product_id]" required
                                                    class="product-select w-full px-2 py-1 rounded bg-gray-100 dark:bg-gray-700
                                                           text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600">
                                                    <option value="">{{ __('-- Pilih Produk --') }}</option>
                                                    @foreach ($productsBySupplier as $supplierId => $productGroup)
                                                        @php
                                                            $supplier = $suppliers->firstWhere('id', $supplierId);
                                                        @endphp
                                                        <optgroup label="Supplier: {{ $supplier ? $supplier->name_supplier : 'Unknown' }}">
                                                            @foreach ($productGroup as $prod)
                                                                <option value="{{ $prod->id }}"
                                                                    {{ $prod->id == ($item['product_id'] ?? '') ? 'selected' : '' }}>
                                                                    {{ $prod->name_product }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-2 py-1">
                                                <input type="number" name="items[{{ $i }}][quantity]" min="1"
                                                       value="{{ $item['quantity'] ?? 1 }}"
                                                       class="qty-input w-full px-2 py-1 rounded bg-gray-100 dark:bg-gray-700
                                                              text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600">
                                            </td>
                                            <td class="px-2 py-1">
                                                <input type="text" name="items[{{ $i }}][price]" readonly
                                                       value="{{ $item['price'] ?? '' }}"
                                                       class="price-input w-full px-2 py-1 rounded bg-gray-100 dark:bg-gray-700
                                                              text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600">
                                            </td>
                                            <td class="px-2 py-1">
                                                <span class="subtotal-span">
                                                    {{ number_format(($item['quantity'] ?? 0) * ($item['price'] ?? 0),0,',','.') }}
                                                </span>
                                            </td>
                                            <td class="px-2 py-1 text-center">
                                                <button type="button" class="remove-row text-red-500">×</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" id="add-row"
                                class="mt-2 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded shadow text-xs">
                                + Tambah Baris
                            </button>
                        </div>

                        {{-- Submit --}}
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                                Update Purchase
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        const productsBySupplier = {!! json_encode($productsBySupplier, JSON_NUMERIC_CHECK) !!};

        document.addEventListener('DOMContentLoaded', () => {
            let rowIndex = 1;
            const supplierSelect = document.getElementById('supplier-select');
            const itemsBody     = document.getElementById('items-body');
            const addRowBtn     = document.getElementById('add-row');

            function renderProductOptions(row, supplierId) {
                const select = row.querySelector('.product-select');
                select.innerHTML = '<option value="">{{ "-- Pilih Produk --" }}</option>';
                (productsBySupplier[supplierId] || []).forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.name;
                    select.appendChild(opt);
                });
                row.querySelector('.price-input').value = '';
                row.querySelector('.subtotal-span').textContent = '0';
            }

            function updateSubtotal(row) {
                const qty   = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                row.querySelector('.subtotal-span').textContent = (qty * price).toLocaleString();
            }

            function bindRowEvents(row) {
                const prodSelect = row.querySelector('.product-select');
                const qtyInput   = row.querySelector('.qty-input');

                prodSelect.addEventListener('change', () => {
                    const supId = supplierSelect.value;
                    if (!supId) {
                        alert('Silakan pilih supplier terlebih dahulu!');
                        prodSelect.value = '';
                        return;
                    }
                    // prevent duplicate
                    const sels = Array.from(document.querySelectorAll('.product-select'))
                        .map(el => el.value).filter(v=>v);
                    if (new Set(sels).size !== sels.length) {
                        alert('Produk sudah dipilih di baris lain!');
                        prodSelect.value = '';
                        return;
                    }
                    const prod = (productsBySupplier[supId]||[]).find(p=>p.id==prodSelect.value);
                    row.querySelector('.price-input').value = prod ? prod.price : '';
                    updateSubtotal(row);
                });

                qtyInput.addEventListener('input', () => updateSubtotal(row));

                row.querySelector('.remove-row').addEventListener('click', () => {
                    if (document.querySelectorAll('.item-row').length > 1) {
                        row.remove();
                    } else {
                        alert('Harus ada minimal satu item.');
                    }
                });
            }

            // bind initial row
            bindRowEvents(itemsBody.querySelector('.item-row'));

            supplierSelect.addEventListener('change', () => {
                document.querySelectorAll('.item-row').forEach(row => {
                    renderProductOptions(row, supplierSelect.value);
                });
            });

            addRowBtn.addEventListener('click', () => {
                if (!supplierSelect.value) {
                    alert('Silakan pilih supplier terlebih dahulu sebelum menambah baris.');
                    return;
                }
                const template = itemsBody.querySelector('.item-row');
                const newRow   = template.cloneNode(true);

                newRow.querySelector('.qty-input').value = 1;
                newRow.querySelector('.subtotal-span').textContent = '0';
                newRow.querySelector('.price-input').value     = '';

                newRow.querySelectorAll('select, input').forEach(el => {
                    const nm = el.getAttribute('name').replace(/\[\d+\]/, `[${rowIndex}]`);
                    el.setAttribute('name', nm);
                });

                template.after(newRow);
                bindRowEvents(newRow);
                renderProductOptions(newRow, supplierSelect.value);
                rowIndex++;
            });
        });
    </script>
</x-app-layout>
