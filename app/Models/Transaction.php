<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    // use HasFactory;
    public static function loadCsvData($filePath) {
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
                    $category = Bucket::whereRaw("LOWER(?) LIKE LOWER(concat('%', `vendor`, '%'))", [$vendor])->value('category');

                    // Log::info("Vendor: $vendor");
                    // Log::info("Category: $category");
    
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

    private static function storeImportedFile($filePath) {
        $fileName = basename($filePath);
        $newFileName = $fileName . '.imported';
        // storage_path generates the full path to the storage directory, and appends whatever you pass as an argument to it
        $newFilePath = storage_path('imports/' . $newFileName);
        
        if (!copy($filePath, $newFilePath)) {
            throw new Exception("Failed to move and rename file: $filePath");
        } 
    }
}
