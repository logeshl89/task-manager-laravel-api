<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Task Manager - REST API Documentation",
 *      description="Task Manager - REST API Documentation built with Laravel",
 *      @OA\Contact(
 *          email="victortavaresdev@gmail.com"
 *      )
 * ),
 * @OA\SecurityScheme(
 *     type="http",
 *     name="Access token",
 *     in="header",
 *     scheme="bearer",
 *     securityScheme="bearerAuth"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
