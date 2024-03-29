<?php

namespace App\Rules;

use Closure;
use App\Models\Bucket;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueVendorCategory implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        $vendor = Request::get('vendor');
        $category = Request::get('category');

        $exists = Bucket::where('vendor', $vendor)
            ->where('category', $category)
            ->exists();

        if ($exists) {
            $fail(
                'The :attribute is already paired with a category.'
            )->translate();
        }
    }
}
