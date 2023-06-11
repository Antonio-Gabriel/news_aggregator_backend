<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\PathItem(path="/api")
 * @OA\Info( version="1.0.0", title="News Aggregator",
 *    description="An application to aggregate news based to external news website"
 * )
 * 
 * @OA\Get(
 *     path="/api",
 *     tags={"Welcome"},
 *     description="Welcome page",
 *     @OA\Response(response="200", description="Welcome page")
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
