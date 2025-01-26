<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data = null, $message = 'Operation Successful', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'state' => 'success',
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function error($message = 'Operation failed', $code = 400, $data = null)
    {
        return response()->json([
            'code' => $code,
            'state' => 'failure',
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}
