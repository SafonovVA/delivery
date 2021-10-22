<?php


namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait JsonApiResponse
 * @package App\Http\Traits
 */
trait JsonApiResponse
{
    /**
     * @param mixed $data
     * @param int $status
     * @return JsonResponse
     */
    private function success($data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $status);
    }

    /**
     * @param int $status
     * @return JsonResponse
     */
    private function successNoData(int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true
        ], $status);
    }

    /**
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    private function failure(string $message, int $status = 422): JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors' => $message,
        ], $status);
    }
}
