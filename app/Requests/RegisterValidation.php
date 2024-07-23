<?php

namespace App\Requests;

class RegisterValidation extends BaseRequestFormApi
{
    // Determine the rules for the registration process API:
    public function rules(): array
    {
        return [
            "name" => 'required|min:2|max:20',
            "email" => 'required|email|unique:users',
            "password" => 'required|min:6|max:100',



        ];
    }
}
