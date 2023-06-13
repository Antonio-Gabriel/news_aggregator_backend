<?php

namespace App\Http\Errors;

use Illuminate\Support\Facades\Log;

trait BadRequest
{
    static function error_400(mixed $badResponse)
    {
        if (!$badResponse) {
            Log::error("An error occured on update process");
            return response("An error occured!", status: 400);
        }
    }
}
