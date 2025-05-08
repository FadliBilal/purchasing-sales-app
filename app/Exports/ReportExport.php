<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Sale::with('customer')
            ->whereBetween('sales_date', [$this->startDate, $this->endDate])
            ->get()
            ->map(function ($sale) {
                return [
                    'Tanggal' => $sale->sales_date,
                    'Pelanggan' => $sale->customer->name_customer ?? '-',
                    'Total' => $sale->total_amount,
                ];
            });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Pelanggan', 'Total'];
    }
}
