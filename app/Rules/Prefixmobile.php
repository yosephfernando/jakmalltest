<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Prefixmobile implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passed = false;
        $substrVal = substr($value, 0, 3);
        $digits = strlen($value);
        if($substrVal == "081" && ($digits >= 7 && $digits <= 12)){
            $passed = true;
        }
        return $passed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number format is invalid.';
    }
}
