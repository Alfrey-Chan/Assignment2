<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bucket extends Model
{
    protected $fillable = ['vendor', 'category'];

    // create method automatically tries to set created_at and updated_at timestamps
    // so we set the built-in property timestamps to false
    public $timestamps = false;

    public static function createBucket($data)
    {
        $vendor = $data['vendor'];
        $category = $data['category'];

        $bucket = new Bucket([
            'vendor' => $vendor,
            'category' => $category,
        ]);
        $bucket->save();

        return $bucket;
    }

    public static function updateBucket(
        Bucket $bucket,
        Request $request
    ) {
        $bucket->vendor = $request->vendor;
        $bucket->category = $request->category;

        $bucket->save();

        return $bucket;
    }
}
