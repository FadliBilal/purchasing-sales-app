<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_supplier' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);
    
        $supplier = Supplier::create([
            'name_supplier' => $request->name_supplier,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    
        Session::flash('success', 'Supplier berhasil ditambahkan!');
        
        return redirect()->route('suppliers.index');
    }

    public function show(Supplier $supplier)
    {
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name_supplier' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);
    
        $supplier->update([
            'name_supplier' => $request->name_supplier,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    
        Session::flash('success', 'Supplier berhasil diperbarui!');
    
        return redirect()->route('suppliers.index');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
    
        Session::flash('success', 'Supplier berhasil dihapus!');
    
        return redirect()->route('suppliers.index');
    }
}
