<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    protected $fillable = ['vendor', 'category'];

    // create method automatically tries to set created_at and updated_at timestamps
    // so we set the built-in property timestamps to false
    // public $timestamps = false;
}
