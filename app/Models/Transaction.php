<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
  protected $fillable = [ // TODO
    'date',
    'vendor',
    'category',
    'spend',
    'deposit',
    'balance'
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
          $category = Bucket::whereRaw("LOWER(?) LIKE '%' || LOWER(\"vendor\") || '%'", [$vendor])->value('category');

          $transaction = new Transaction([
            'date' => $date,
            'vendor' => $vendor,
            'category' => $category ? $category : "Miscellaneous", // if no matching category, default to Miscellaneous
            'spend' => $row[2] ? $row[2] : 0, // if no spend value, set to 0
            'deposit' => $row[3] ? $row[3] : 0, // if no deposit value, set to 0
            'balance' => $row[4]
          ]);
          $transaction->save();
        }
        fclose($handle);

        Transaction::storeImportedFile($filePath);
      }
    } catch (Exception $e) {
      Log::error("Error loading csv data: " . $e);
    }
  }

  private static function storeImportedFile($filePath)
  {
    $fileName = basename($filePath);
    $newFileName = $fileName . '.imported';
    // storage_path generates the full path to the storage directory, and appends whatever you pass as an argument to it
    $newFilePath = storage_path('imports/' . $newFileName);

    if (!copy($filePath, $newFilePath)) {
      throw new Exception("Failed to move and rename file: $filePath");
    }
  }

  public static function createNewTransaction($data)
  {
    // $date = $data->date;
    // $vendor = $data->vendor;
    // $spend = $data->spend ? $data->spend : 0;
    // $deposit = $data->deposit ? $data->deposit : 0; 
    $date = $data['date'];
    $vendor = $data['vendor'];
    $spend = $data['spend'] ? $data['spend'] : 0;
    $deposit = $data['deposit'] ? $data['deposit'] : 0;
    $balance = $data['balance'];


    // $balance = Transaction::calculateBalance($date, $spend, $deposit);
    if ($balance < 0) {
      throw new \Exception("Transaction failed. Balance cannot be less than 0.");
    }

    $category = Transaction::mapCategory($vendor);

    $transaction = new Transaction([
      'date' => $date,
      'vendor' => $vendor,
      'category' => $category,
      'spend' => $spend,
      'deposit' => $deposit,
      'balance' => $balance
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

    $startBalance = $previousTransaction ? $previousTransaction->balance : 0;
    $balance = $startBalance + $deposit - $spend; // null is treated as 0 in PHP

    return $balance;
  }
  public static function mapCategory($vendor)
  {
    $mappedCategory = Bucket::whereRaw("LOWER(?) LIKE LOWER('%' || \"vendor\" || '%')", [$vendor])
      ->value('category');
    $category = $mappedCategory ?: "Miscellaneous";

    return $category;
  }

  public static function updateSubsequentBalances($transaction)
  {
    $subsequentTransactions = Transaction::where('date', '>', $transaction->date)
      ->orderBy('date', 'asc')
      ->get();

    $currentBalance = $transaction->balance;
    foreach ($subsequentTransactions as $subsequentTransaction) {
      $currentBalance += $subsequentTransaction->deposit - $subsequentTransaction->spend;
      $subsequentTransaction->balance = $currentBalance;
      $subsequentTransaction->save();
    }
  }

  public static function checkNegativeBalances($data)
  {
    $currentBalance = $data['balance'];
    $subsequentTransactions = Transaction::where('date', '>', $data['date'])
      ->orderBy('date', 'asc')
      ->get();

    foreach ($subsequentTransactions as $subsequentTransaction) {
      $currentBalance += $subsequentTransaction->deposit - $subsequentTransaction->spend;
      if ($currentBalance < 0) {
        return false;
      }
    }

    return true;
  }
}
