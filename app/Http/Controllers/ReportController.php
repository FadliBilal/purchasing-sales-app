<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal
        $startDate = $request->start_date ?? null;  
        $endDate = $request->end_date ?? null; 

        // Ambil data penjualan
        $sales = Sale::with('customer')
            ->whereBetween('sales_date', [$startDate, $endDate])
            ->get();

        // Ambil data pembelian
        $purchases = Purchase::with('supplier')
            ->whereBetween('purchase_date', [$startDate, $endDate])
            ->get();

        // Summary
        $totalSales = $sales->sum('total_amount');
        $totalPurchases = $purchases->sum('total_amount');

        return view('reports.index', compact(
            'sales', 'purchases', 'startDate', 'endDate', 'totalSales', 'totalPurchases', 
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        return Excel::download(new ReportExport($startDate, $endDate), 'laporan_penjualan.xlsx');
    }

    public function pivot()
    {
        $salesItems = SaleItem::with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Sale',
                    'product' => $item->product->name_product ?? '-',
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ];
            });
    
        $purchaseItems = PurchaseItem::with('product')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Purchase',
                    'product' => $item->product->name_product ?? '-',
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ];
            });
    
        $data = $salesItems->merge($purchaseItems);
    
        return view('reports.pivot', compact('data'));
    }
        
}
