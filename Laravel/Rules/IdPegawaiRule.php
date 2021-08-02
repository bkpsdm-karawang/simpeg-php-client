<?php

namespace SimpegClient\Laravel\Rules;

use Illuminate\Contracts\Validation\Rule;
use SimpegClient\Laravel\Facades\SimpegClient;

class IdPegawaiRule implements Rule
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
            SimpegClient::module('pegawai')->getDetail($value);

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
        return 'The :attribute is not valid Id Pegawai';
    }
}
