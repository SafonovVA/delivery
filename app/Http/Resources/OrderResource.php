<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @OA\Schema(
 *     schema="OrderCollection",
 *     description="Order collection",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         description="Id заказа",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="description",
 *         description="Описание",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="price",
 *         description="Цена",
 *         type="number",
 *     ),
 *     @OA\Property(
 *         property="accepted_at",
 *         description="Дата принятия заказа в отделение курьерской службы",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="delivered_at",
 *         description="Дата доставки заказа в точку назначения",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         description="Дата создания",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         description="Дата обновления",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="coordinates",
 *         description="Координаты",
 *         type="object",
 *         @OA\Property(
 *             property="latitude",
 *             description="Широта",
 *             type="string",
 *         ),
 *         @OA\Property(
 *             property="longitude",
 *             description="Долгота",
 *             type="string",
 *         ),
 *     ),
 *     @OA\Xml(
 *         name="OrderCollection"
 *     )
 * )
 */

/** @OA\Schema(
 *     schema="OrderResource",
 *     description="Order resource",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         description="Id заказа",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="description",
 *         description="Описание",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="price",
 *         description="Цена",
 *         type="number",
 *     ),
 *     @OA\Property(
 *         property="accepted_at",
 *         description="Дата принятия заказа в отделение курьерской службы",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="delivered_at",
 *         description="Дата доставки заказа в точку назначения",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         description="Дата создания",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         description="Дата обновления",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="coordinates",
 *         description="Координаты",
 *         type="object",
 *         @OA\Property(
 *             property="latitude",
 *             description="Широта",
 *             type="string",
 *         ),
 *         @OA\Property(
 *             property="longitude",
 *             description="Долгота",
 *             type="string",
 *         ),
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="object",
 *         ref="#/components/schemas/OrderStatus",
 *     ),
 *     @OA\Property(
 *         property="courier",
 *         type="object",
 *         ref="#/components/schemas/Courier",
 *     ),
 *     @OA\Xml(
 *         name="OrderResource"
 *     )
 * )
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {

        /** @var Order $this */
        $coordinates = explode(':', $this->coordinates);

        return [
            'id' => $this->id,
            'description' => $this->description,
            'coordinates' => [
                'latitude' => reset($coordinates),
                'longitude' => last($coordinates)
            ],
            'price' => $this->price,
            'status' => new OrderStatusResource($this->whenLoaded('status')),
            'courier' => new CourierResource($this->whenLoaded('courier')),
            'accepted_at' => $this->accepted_at,
            'delivered_at' => $this->delivered_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
