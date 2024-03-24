<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\ConsoleOutput; // for debugging, outputs to terminal 

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $transactions = Transaction::orderBy('date', 'desc')
                                    ->orderBy('id', 'desc')
                                    ->paginate(10);
        $headers = Schema::getColumnListing('transactions');
        
        return view('transaction.index', [
            'transactions' => $transactions,
            'headers' => $headers
            ])->with(request()->input('page'));
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
        // validate function will redirect the user to previous location if any checks fail
        $validatedData = self::validateTransaction($request);
        // $validatedData = $request->validate([ 
        //     'date' => 'required|date',
        //     'vendor' => 'required|string',
        //     'spend' => 'nullable|numeric',
        //     'deposit' => 'nullable|numeric',
        //     'balance' => 'required|numeric'
        // ]);

        // $output = new ConsoleOutput();
        // $output->writeln('validatedData: ' . print_r($validatedData, true));

        try {
            // check for any negative balances before creating new transaction
            // if (!Transaction::checkNegativeBalances($validatedData)) {
            //     return redirect()->back()->withErrors('Transaction failed. Subsequent tranction balance(s) resulted in less than 0');
            // }
            Transaction::checkNegativeBalances($validatedData);
            $transaction = Transaction::createNewTransaction($validatedData);
            Transaction::updateSubsequentBalances($transaction);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('transaction.index')->with('success', 'Transaction added successfully.');
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
        $validatedData = self::validateTransaction($request);
        try {
            // check for any negative balances before updating existing transaction
            Transaction::checkNegativeBalances($validatedData);
            $updatedTransaction = Transaction::updateTransaction($transaction, $request);
            $output = new ConsoleOutput();
            $output->writeln('data: ' . print_r($updatedTransaction, true));

            Transaction::updateSubsequentBalances($updatedTransaction);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('transaction.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        return 'destroy';
    }

    private function validateTransaction(Request $request) {
        return $request->validate([ 
            'date' => 'required|date',
            'vendor' => 'required|string',
            'spend' => 'nullable|numeric|min:0', // TODO: cannot be negative check 
            'deposit' => 'nullable|numeric|min:0',
            'balance' => 'required|numeric'
        ]);
    }
}
