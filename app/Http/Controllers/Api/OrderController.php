<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Traits\JsonApiResponse;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use JsonApiResponse;

    /**
     * @OA\Get(
     *      path="/api/orders",
     *      operationId="ordersIndex",
     *      tags={"Orders"},
     *      summary="Массив заказов",
     *      description="Возращает массив заказов",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *			    @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  default=true
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/OrderCollection")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     		@OA\JsonContent(
     *              type="object",
     *				@OA\Property(
     *                    property="success",
     *                    type="boolean",
     *                    default=false
     *                ),
     *				@OA\Property(
     *                    property="errors",
     *                    type="object"
     *                )
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::all();

        return $this->success(OrderResource::collection($orders));
    }

    /**
     * @OA\Post(
     *        path="/api/orders",
     *        operationId="ordersCreate",
     *      tags={"Orders"},
     *      summary="Создание модели заказа",
     *      description="Возращает созданную модель заказа",
     *      requestBody={"$ref": "#/components/requestBodies/CreateOrderRequest"},
     *      @OA\Response(
     *          response=200,
     *          description="Создание модели заказа",
     *          @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(
     *                    property="success",
     *                    type="boolean",
     *                    default=true
     *              ),
     *				@OA\Property(
     *                    property="data",
     *                    type="object",
     *                  ref="#/components/schemas/OrderResource"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Неавторизированный пользователь"
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Invalid data"
     *      ),
     *      security={{"bearerAuth": {}}}
     *    )
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = Order::create($request->all());
        $order->load(['courier', 'status']);

        return $this->success(new OrderResource($order));
    }

    /**
     * @OA\Get(
     *      path="/api/orders/{id}",
     *      operationId="ordersShow",
     *      tags={"Orders"},
     *      summary="Детали заказа",
     *      description="Возращает заказ",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id заказа",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *			    @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  default=true
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/OrderResource"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     		@OA\JsonContent(
     *              type="object",
     *				@OA\Property(
     *                    property="success",
     *                    type="boolean",
     *                  default=false
     *                ),
     *				@OA\Property(
     *                    property="errors",
     *                    type="object"
     *                )
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with(['courier', 'status'])->findOrFail($id);

        return $this->success(new OrderResource($order));
    }

    /**
     * @OA\Patch(
     *      path="/api/orders/{id}",
     *      operationId="ordersUpdate",
     *      tags={"Orders"},
     *      summary="Изменение модели заказа",
     *      description="Возращает измененную модель заказа",
     *      requestBody={"$ref": "#/components/requestBodies/UpdateOrderRequest"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Id заказа",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Изменение модели заказа",
     *          @OA\JsonContent(
     *              type="object",
     *     			@OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  default=true
     *              ),
     *				@OA\Property(
     *                  property="data",
     *                  type="object",
     *                  ref="#/components/schemas/OrderResource"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Неавторизированный пользователь"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Invalid data"
     *      ),
     *      security={{"bearerAuth": {}}}
     *    )
     *
     * @param UpdateOrderRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, int $id): JsonResponse
    {
        /** @var Order $order */
        $order = Order::findOrFail($id);
        $order->update($request->all());
        $order->load(['courier', 'status']);

        return $this->success(new OrderResource($order));
    }


    /**
     * @OA\Get(
     *      path="/api/orders/{courierId}/history",
     *      operationId="ordersHistory",
     *      tags={"Orders"},
     *      summary="Список выполненных курьером заказов",
     *      description="Возращает список выполненных курьером заказов",
     *      @OA\Parameter(
     *          name="courierId",
     *          description="Id курьера",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *			    @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  default=true
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/OrderCollection")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     		@OA\JsonContent(
     *              type="object",
     *				@OA\Property(
     *                    property="success",
     *                    type="boolean",
     *                  default=false
     *                ),
     *				@OA\Property(
     *                    property="errors",
     *                    type="object"
     *                )
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
     * Display the specified resource.
     *
     * @param int $courierId
     * @return JsonResponse
     */
    public function history(int $courierId): JsonResponse
    {
        $orders = Order::where([
            'courier_id' => $courierId,
            'order_status_id' => array_search('delivered', OrderStatus::STATUSES)
        ])->get();

        return $this->success(OrderResource::collection($orders));
    }
}
