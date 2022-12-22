<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * Return simple json response. For testing api throttling.
     *
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        return response()->json(['data'=>'test']);
    }
}
