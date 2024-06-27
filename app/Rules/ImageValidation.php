<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($file , $extension)
    {
        $this->file = $file;
        $this->extension = $extension;
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
        $status = true;
        foreach ($this->file as $f) {
            $ext = pathinfo($f->getClientOriginalName(), PATHINFO_EXTENSION);
            // $sizeInMb = $f->getSize() / 1024 / 1024;
            if ((in_array($ext, $this->extension) == false)) {
                $status = false;
                break;
            }
        }

        return $status;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Extension is not jpg,jpeg or png.';
    }
}
