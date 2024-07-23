<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginService
{

    // Service of login process:
    public function loginUser(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }
        return null;
    }
}
