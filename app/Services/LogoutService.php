<?php

namespace App\Services;

use App\Models\User;

class LogoutService
{

    //Service of logout process:
    public function logoutUser()
    {
        $user = User::find(auth('sanctum')->id());
        if ($user) {
            $user->tokens()->delete();
            return true;
        }
        return false;
    }
}
