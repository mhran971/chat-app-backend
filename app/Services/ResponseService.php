<?php

namespace App\Services;


class ResponseService
{
    /**
    Service for manage response operations in the system.
     */
    public function sendResponse($response, $status = "Success", $code = "200"): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            [
                'data' => $response,
                'status' => $status,
            ],
            $code
        );
    }

    public function sendError($message, $status = "Failed" , $code = "401"): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            [
                'data' => $message,
                'status' => $status,
                'code' => $code,
            ],
            $code
        );
    }
}
