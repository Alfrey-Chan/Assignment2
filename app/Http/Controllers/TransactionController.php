<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // $transactions = Transaction::query()->paginate(5);
        $transactions = Transaction::all();
        $headers = Schema::getColumnListing('transactions');
        
        return view('transaction.index', [
            'transactions' => $transactions,
            'headers' => $headers
            ]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 'store';
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('transaction.show', ['transaction' => $transaction]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        return view('transaction.edit', ['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        return 'update';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        return 'destroy';
    }
}
