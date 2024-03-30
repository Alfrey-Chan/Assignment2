<?php

namespace App\Rules;

use Closure;
use App\Models\Bucket;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueVendorCategory implements ValidationRule
{
    private $vendor;
    private $category;

    public function __construct($vendor, $category)
    {
        $this->vendor = $vendor;
        $this->category = $category;
    }

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
        $exists = Bucket::whereRaw('LOWER(vendor) = LOWER(?)', [$this->vendor])
            ->whereRaw('LOWER(category) = LOWER(?)', [$this->category])
            ->exists();

        if ($exists) {
            $fail(
                $this->vendor .
                    ' is already paired with ' .
                    $this->category .
                    '.'
            );
        }
    }
}
