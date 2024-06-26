<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput; // for debugging, outputs to terminal

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buttons = [
            [
                'href' => route('transaction.create'),
                'text' => 'New Transaction',
                'adminOnly' => false,
            ],
            [
                'href' => route('transaction.import'),
                'text' => 'Upload CSV',
                'adminOnly' => false,
            ],
            [
                'href' => route('transaction.summary'),
                'text' => 'Summary',
                'adminOnly' => false,
            ],
            [
                'href' => route('bucket.index'),
                'text' => 'View Buckets',
                'adminOnly' => true,
            ],
            [
                'href' => route('approvals'),
                'text' => 'Approve Users',
                'adminOnly' => true,
            ],
        ];
        $transactions = Transaction::orderBy('date', 'desc')
            ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $headers = Schema::getColumnListing('transactions');

        return view('transaction.index', [
            'transactions' => $transactions,
            'headers' => $headers,
            'buttons' => $buttons,
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

        try {
            // Transaction::checkNegativeBalances($validatedData);
            Transaction::createNewTransaction($validatedData);
            Transaction::updateSubsequentBalances();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('transaction.index')
            ->with('success', 'Transaction added successfully.');
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
            Transaction::updateTransaction($transaction, $request);
            Transaction::updateSubsequentBalances();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('transaction.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        Transaction::updateSubsequentBalances();

        return redirect()
            ->route('transaction.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    private function validateTransaction(Request $request)
    {
        return $request->validate([
            'date' => 'required|date',
            'vendor' => 'required|string',
            'spend' => 'nullable|numeric|min:0',
            'deposit' => 'nullable|numeric|min:0',
            'balance' => 'numeric',
            'user_id' => 'required|string',
        ]);
    }

    public function showImportForm()
    {
        return view('transaction.import');
    }

    public function importFromCsv(Request $request)
    {
        $request->validate([
            'csvFile' => 'required|file|mimes:csv,txt',
        ]);

        try {
            $tempFilePath = $request->file('csvFile')->store('temp');
            $originalFileName = $request
                ->file('csvFile')
                ->getClientOriginalName();
            $importedFileName =
                pathinfo($originalFileName, PATHINFO_FILENAME) .
                '.imported' .
                '.' .
                pathinfo($originalFileName, PATHINFO_EXTENSION);

            Transaction::loadCsvData(storage_path('app/' . $tempFilePath));
            $newPath = 'imports/' . $importedFileName;
            Storage::move($tempFilePath, $newPath);
        } catch (\Exception $e) {
            Log::error('Error' . $e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('transaction.index')
            ->with('success', 'CSV file uploaded successfully.');
    }

    public function summary(Request $request)
    {
        $buttons = [
            [
                'href' => route('transaction.index'),
                'text' => 'Transactions',
                'adminOnly' => false,
            ],
            [
                'href' => route('transaction.import'),
                'text' => 'Upload CSV',
                'adminOnly' => false,
            ],
            [
                'href' => route('bucket.index'),
                'text' => 'View Buckets',
                'adminOnly' => true,
            ],
            [
                'href' => route('approvals'),
                'text' => 'Approve Users',
                'adminOnly' => true,
            ],
        ];
        $year = $request->get('year');
        $summary = Transaction::getSummary($year);
        $headers = Schema::getColumnListing('transactions');
        return view('transaction.summary', compact('summary'), [
            'summary' => $summary,
            'buttons' => $buttons,
            'headers' => $headers,
        ]);
    }
}
