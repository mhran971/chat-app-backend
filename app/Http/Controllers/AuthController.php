<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\BaseController;
use App\Requests\LoginValidation;
use App\Requests\RegisterValidation;
use App\Services\LoginService;
use App\Services\LogoutService;
use App\Services\RegisterService;
use Illuminate\Http\Request;


class AuthController extends BaseController
{

    public RegisterService $registerService;
    public LoginService $loginService;
    public LogoutService $logoutService;

    public function __construct(RegisterService $registerService, LoginService $loginService, LogoutService $logoutService)
    {
        $this->registerService = $registerService;
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
    }

    // Register Function:
    public function register(RegisterValidation $registerValidation)
    {
        if (!empty($registerValidation->getErrors())) {
            return response()->json($registerValidation->getErrors(), 406);
        }

        $user = $this->registerService->registerUser($registerValidation->request()->all());
        $user->remember_token = $user->createToken('AppName')->plainTextToken;
        $user->save();

        $message['user'] = $user->toArray();
        $message['token'] = $user->api_token;

        return $this->sendResponse($message);
    }

    // Login Function:
    public function login(LoginValidation $loginValidation)
    {
        if (!empty($loginValidation->getErrors())) {
            return response()->json($loginValidation->getErrors(), 406);
        } else {
            $user = $this->loginService->loginUser($loginValidation->request()->all());
            if ($user) {
                $message = "You Logged in Successfully";
                $token = $user->createToken('AppName')->plainTextToken;
                return $this->sendResponse(['message' => $message, 'token' => $token, 'role_id ' => $user->role_id]);
            } else {
                $message = "Invalid credentials";
                return $this->sendError(message: $message);
            }
        }
    }

    // Logout Function:
    public function logout(Request $request)
    {
        $response = $this->logoutService->logoutUser();
        if ($response) {
            $message = "Logout Successfully.";
            return $this->sendResponse($message, 204);
        } else {
            $message = "Something goes wrong!!";
            return $this->sendError($message);
        }
    }
}
