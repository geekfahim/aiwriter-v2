<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedAudioFormat implements Rule
{
    private $allowedFormats;

    public function __construct(array $allowedFormats)
    {
        $this->allowedFormats = $allowedFormats;
    }

    public function passes($attribute, $value)
    {
        $extension = strtolower($value->getClientOriginalExtension());

        return in_array($extension, $this->allowedFormats);
    }

    public function message()
    {
        return 'The :attribute must be a file of type: ' . implode(',', $this->allowedFormats) . '.';
    }
}