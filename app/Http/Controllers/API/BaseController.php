<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * @param string $status
     * @param array $data
     * @param string|null $message
     * @return JsonResponse
     */
    public function sendResponse(string $status, $data = [], string $message = null): JsonResponse
    {
        return response()->json(array_merge([
            'status'  => $status,
            'message' => $message
        ], $data));
    }
}
