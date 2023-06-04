<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConflictException extends Exception
{
    public function render(Request $request): Response
    {
        $code = 'CONFLICT';
        $message = 'Email already exists';
        $status = 409;

        return response([
            'code' => $code,
            'message' => $message,
            'status' => $status
        ], 409);
    }
}
