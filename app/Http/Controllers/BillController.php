<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::where('user_id', auth()->id())->get();
        return view('dashboard', compact('bills'));
    }

    public function create()
    {
        return view('bills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bill_name' => 'required|string',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        Bill::create([
            'user_id'   => auth()->id(),
            'bill_name' => $request->bill_name,
            'amount'    => $request->amount,
            'due_date'  => $request->due_date,
            'status'    => 'belum',
        ]);

        return redirect()->route('dashboard');
    }

    public function update(Bill $bill)
    {
        if ($bill->user_id !== auth()->id()) {
            abort(403);
        }

        $bill->update([
            'status' => 'lunas'
        ]);

        return back();
    }

    public function destroy(Bill $bill)
    {
        if ($bill->user_id !== auth()->id()) {
            abort(403);
        }

        $bill->delete();
        return back();
    }
}
