<?php

namespace App\Support;

class ApiError
{
    public static function response(string $message, int $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }
}