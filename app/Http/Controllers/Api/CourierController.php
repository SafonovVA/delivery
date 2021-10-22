<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourierResource;
use App\Http\Traits\JsonApiResponse;
use App\Models\Courier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    use JsonApiResponse;

    /** @OA\Get(
     *     path="/api/couriers",
     *     summary="Список курьеров",
     *     description="Возращает список курьеров",
     *     tags={"Courier"},
     *     operationId="courierIndex",
     *     @OA\Parameter(
     *     		name="free",
     *     		in="query",
     *     		description="Только свободные",
     *     		required=false,
     *     		@OA\Schema(
     *         		type="boolean"
     *     		)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список курьеров",
     *         @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(
     *                    property="success",
     *                    type="boolean",
     *                    default=true
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Courier")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     	    @OA\JsonContent(
     *              type="object",
     *			    @OA\Property(
     *                   property="success",
     *                   type="boolean",
     *                   default=false
     *              ),
     *			    @OA\Property(
     *                   property="errors",
     *                   type="object"
     *              )
     *          )
     *      ),
     *    )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {

        $couriers = $request->query('free') === 'true'
            ? Courier::free()->get()
            : Courier::all();

        return $this->success(CourierResource::collection($couriers));
    }
}
