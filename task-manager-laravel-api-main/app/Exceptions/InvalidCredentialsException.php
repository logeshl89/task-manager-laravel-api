<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvalidCredentialsException extends Exception
{
    public function render(Request $request): Response
    {
        $code = 'BAD_REQUEST';
        $message = 'Invalid credentials';
        $status = 400;

        return response([
            'code' => $code,
            'message' => $message,
            'status' => $status
        ], 400);
    }
}
