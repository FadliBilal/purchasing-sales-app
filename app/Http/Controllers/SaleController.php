<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products  = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'sales_date'         => 'required|date',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
        ]);

        $productIds = collect($data['items'])->pluck('product_id')->unique();
        $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($data['items'] as $idx => $item) {
            $prod = $products[$item['product_id']];
            if ($prod->stock < $item['quantity']) {
                throw ValidationException::withMessages([
                    "items.{$idx}.quantity" => "Stok produk “{$prod->name_product}” hanya {$prod->stock}.",
                ]);
            }
        }

        DB::transaction(function () use ($data, $products) {
            $totalAmount = 0;
            foreach ($data['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $sale = Sale::create([
                'customer_id'  => $data['customer_id'],
                'sales_date'   => $data['sales_date'],
                'total_amount' => $totalAmount,
            ]);

            foreach ($data['items'] as $item) {
                $subtotal = $item['quantity'] * $item['price'];

                $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $subtotal,
                ]);

                $products[$item['product_id']]->decrement('stock', $item['quantity']);
            }
        });

        return redirect()->route('sales.index')
                         ->with('success', 'Data penjualan berhasil disimpan!');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        $products  = Product::all();
        $sale->load('items');
        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'customer_id'        => 'required|exists:customers,id',
            'sales_date'         => 'required|date',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
        ]);

        $sale->items->each(function($old) {
            $old->product->increment('stock', $old->quantity);
        });

        $productIds = collect($data['items'])->pluck('product_id')->unique();
        $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($data['items'] as $idx => $item) {
            $prod = $products[$item['product_id']];
            if ($prod->stock < $item['quantity']) {
                throw ValidationException::withMessages([
                    "items.{$idx}.quantity" => "Stok produk “{$prod->name_product}” hanya {$prod->stock}.",
                ]);
            }
        }

        DB::transaction(function () use ($sale, $data, $products) {
            $totalAmount = 0;
            foreach ($data['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $sale->update([
                'customer_id'  => $data['customer_id'],
                'sales_date'   => $data['sales_date'],
                'total_amount' => $totalAmount,
            ]);

            $sale->items()->delete();

            foreach ($data['items'] as $item) {
                $subtotal = $item['quantity'] * $item['price'];

                $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $subtotal,
                ]);

                $products[$item['product_id']]->decrement('stock', $item['quantity']);
            }
        });

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil diperbarui!');
    }

    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $sale->items->each(fn($it) => $it->product->increment('stock', $it->quantity));
            $sale->items()->delete();
            $sale->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil dihapus!');
    }
}
