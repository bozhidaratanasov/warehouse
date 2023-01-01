<?php

namespace App\Traits;

trait HttpResponses {

    protected function success($data, string $message = null, int $code = 200) 
    {
        return response()->json([
            'status' => 'Request is successful.',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($data, string $message = null, int $code) 
    {
        return response()->json([
            'status' => 'An error has occured.',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}