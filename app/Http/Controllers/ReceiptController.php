<?php

namespace App\Http\Controllers;

use App\Models\TransactionInventory;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index($uuid)
    {
        $transaction = TransactionInventory::with('employee', 'supervisor', 'group', 'details.inventory')->where('id', $uuid)->first();

        return view('receipt-outbound', compact('transaction'));
    }

    public function inbound(Request $request)
    {
        $transaction_ids = $request->query('ids');
        $transactions = TransactionInventory::with('employee', 'supervisor', 'group', 'details.inventory')->whereHas('details', function($query){
            return $query->whereNotNull('return_date');
        })->whereIn('id', $transaction_ids)->get();

        // dd($transactions);
        return view('receipt-inbound', compact('transactions'));
    }
}
