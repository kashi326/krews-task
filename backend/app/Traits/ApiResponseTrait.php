<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function jsonResponse($data = null, $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }
}
