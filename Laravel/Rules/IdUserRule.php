<?php

namespace SimpegClient\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use SimpegClient\Laravel\Facades\SimpegClient;

class IdUserRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            SimpegClient::module('user')->getDetail($value);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not valid Id User Simpeg';
    }
}
