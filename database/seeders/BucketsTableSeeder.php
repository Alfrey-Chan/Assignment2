<?php

namespace Database\Seeders;

use App\Models\Bucket;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BucketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorCategoryMap = [
            'walmart' => 'Groceries',
            'safeway' => 'Groceries',
            'supers' => 'Groceries',
            'costco' => 'Groceries',
            'restaurant' => 'Entertainment',
            'subway' => 'Entertainment',
            'mcdonalds' => 'Entertainment',
            'tim hortons' => 'Entertainment',
            '7-eleven' => 'Entertainment',
            'icbc' => 'Insurance',
            'msp' => 'Insurance',
            'gas' => 'Utilities',
            'shaw' => 'Utilities',
            'rogers' => 'Utilities',
            'donation' => 'Donations',
            'charity' => 'Donations',
            'red cross' => 'Donations',
        ];

        foreach ($vendorCategoryMap as $vendor => $category) {
            Bucket::create([
                'vendor' => $vendor,
                'category' => $category,
            ]);
        }
    }
}
