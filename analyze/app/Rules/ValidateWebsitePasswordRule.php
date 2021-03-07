<?php

namespace App\Rules;

use App\Website;
use Illuminate\Contracts\Validation\Rule;

class ValidateWebsitePasswordRule implements Rule
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
        $website = Website::where('url', '=', request()->route('id'))->first();

        if ($website->password == $value) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The entered password is not correct.');
    }
}
