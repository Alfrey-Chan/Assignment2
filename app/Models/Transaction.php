<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Output\ConsoleOutput;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    /**
     * In Laravel, Eloquent will assume the primary key is 'id'. So in route model binding,
     * transaction/{transaction}/edit, {transaction} will be the 'id' of the transaction.
     * If you have a diff primary key, you can specify it like this:
     *
     * protected $primaryKey = "transaction_id";
     *
     * Otherwise, 'id' will be searched in the table, and error will be thrown if not found.
     */

    protected $fillable = [
        // TODO
        'date',
        'vendor',
        'category',
        'spend',
        'deposit',
        'balance',
        'user_id',
    ];

    // use HasFactory;
    public static function loadCsvData($filePath)
    {
        try {
            if (($handle = fopen($filePath, 'r')) !== false) {
                // skip the first row (header row)
                fgetcsv($handle);

                while (($row = fgetcsv($handle)) !== false) {
                    // convert date from MM/DD/YYYY to YYYY-MM-DD
                    $dateObject = DateTime::createFromFormat('m/d/Y', $row[0]);
                    $date = $dateObject->format('Y-m-d');

                    $vendor = $row[1];

                    // search for a vendor in buckets table, where $vendor is a substring of it
                    $category = Bucket::whereRaw(
                        "LOWER(?) LIKE '%' || LOWER(\"vendor\") || '%'",
                        [$vendor]
                    )->value('category');

                    $transaction = new Transaction([
                        'date' => $date,
                        'vendor' => $vendor,
                        'category' => $category ? $category : 'Miscellaneous', // if no matching category, default to Miscellaneous
                        'spend' => $row[2] ? $row[2] : 0, // if no spend value, set to 0
                        'deposit' => $row[3] ? $row[3] : 0, // if no deposit value, set to 0
                        'balance' => $row[4],
                        'user_id' => auth()->id(),
                    ]);
                    $transaction->save();
                }
                fclose($handle);
            }
        } catch (Exception $e) {
            throw new Exception('Error processing CSV file.');
        }
    }

    // public static function storeImportedFile($filePath)
    // {
    //     $fileName = basename($filePath);
    //     $newFileName = $fileName . '.imported';
    //     // storage_path generates the full path to the storage directory, and appends whatever you pass as an argument to it
    //     $newFilePath = storage_path('imports/' . $newFileName);

    //     if (!copy($filePath, $newFilePath)) {
    //         throw new Exception("Failed to move and rename file: $filePath");
    //     }
    // }

    public static function createNewTransaction($data)
    {
        $date = $data['date'];
        $vendor = $data['vendor'];
        $spend = $data['spend'] ? $data['spend'] : 0;
        $deposit = $data['deposit'] ? $data['deposit'] : 0;
        $balance = $data['balance'];
        $user_id = auth()->id();

        if ($balance < 0) {
            throw new \Exception(
                'Transaction failed. Balance cannot be less than 0.'
            );
        }

        $category = Transaction::mapCategory($vendor);

        $transaction = new Transaction([
            'date' => $date,
            'vendor' => $vendor,
            'category' => $category,
            'spend' => $spend,
            'deposit' => $deposit,
            'balance' => $balance,
            'user_id' => $user_id,
        ]);
        $transaction->save();

        return $transaction;
    }

    public static function calculateBalance($date, $spend, $deposit)
    {
        // Find the most recent transaction before the new one
        $previousTransaction = Transaction::where('date', '<', $date) // get all transactions with date less than the new transaction
            ->orderBy('date', 'desc')
            ->first(); // first row is the most recent

        $startBalance = $previousTransaction
            ? $previousTransaction->balance
            : 0;
        $balance = $startBalance + $deposit - $spend; // null is treated as 0 in PHP

        return $balance;
    }
    public static function mapCategory($vendor)
    {
        $mappedCategory = Bucket::whereRaw(
            "LOWER(?) LIKE LOWER('%' || \"vendor\" || '%')",
            [$vendor]
        )->value('category');
        $category = $mappedCategory ?: 'Miscellaneous';

        return $category;
    }

    public static function updateSubsequentBalances()
    {
        // Fetch the earliest transaction
        $earliestTransaction = self::orderBy('date', 'asc')->first();

        // Set the starting balance to the balance of the earliest transaction
        $balance = $earliestTransaction->balance;

        // Fetch all transactions except the earliest one, sorted by date
        $transactions = self::where('id', '!=', $earliestTransaction->id)
            ->orderBy('date', 'asc')
            ->get();

        foreach ($transactions as $transaction) {
            // Calculate the new balance
            $balance -= $transaction->spend;
            $balance += $transaction->deposit;

            // Update the balance for the current transaction
            $transaction->balance = $balance;
            $transaction->save();
        }
    }

    public static function checkNegativeBalances($data)
    {
        $currentBalance = $data['balance'];
        $subsequentTransactions = Transaction::where('date', '>', $data['date'])
            ->orderBy('date', 'asc')
            ->get();

        foreach ($subsequentTransactions as $subsequentTransaction) {
            $currentBalance +=
                $subsequentTransaction->deposit - $subsequentTransaction->spend;
            if ($currentBalance < 0) {
                throw new \Exception(
                    'Error: Subsequent tranction balance(s) resulted in less than 0'
                );
            }
        }

        return true;
    }

    public static function updateTransaction(
        Transaction $transaction,
        Request $request
    ) {
        $transaction->date = $request->date;
        $transaction->vendor = $request->vendor;
        $transaction->spend = $request->spend;
        $transaction->deposit = $request->deposit;
        $transaction->balance = $request->balance;
        $transaction->category = Transaction::mapCategory($request->vendor);
        $transaction->user_id = auth()->id();

        $transaction->save();

        return $transaction;
    }

    public static function getSummary($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }
        $query = self::select(
            'category',
            DB::raw('SUM(spend) as total_spend'),
            DB::raw('SUM(deposit) as total_deposit')
        )
            ->groupBy('category')
            ->where('user_id', auth()->id());

        if ($year) {
            $query->whereYear('date', $year);
        }

        return $query->get();
    }
}
