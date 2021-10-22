<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CreateOrderRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         type="object",
 *		   @OA\Property(
 *             property="description",
 *             description="Описание заказа",
 *             type="string"
 *         ),
 *		   @OA\Property(
 *             property="price",
 *             description="Цена",
 *             type="number"
 *         ),
 *		   @OA\Property(
 *             property="accepted_at",
 *             description="Дата принятия заказа в отделение курьерской службы",
 *             type="string"
 *         ),
 *		   @OA\Property(
 *             property="delivered_at",
 *             description="Дата доставки заказа в точку назначения",
 *             type="string"
 *         ),
 *		   @OA\Property(
 *             property="coordinates",
 *             description="Координаты в формате latitude:longitude",
 *             type="string"
 *         ),
 *		   @OA\Property(
 *             property="order_status_id",
 *             description="ID статуса заказа",
 *             type="integer"
 *         ),
 *		   @OA\Property(
 *             property="courier_id",
 *             description="ID курьера",
 *             type="integer"
 *         ),
 *     )
 * )
 *
 * @property string $description
 * @property float $price
 * @property string $accepted_at
 * @property string $coordinates
 */
class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'price' => 'required|numeric',
            'coordinates' => [
                'required',
                'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?):*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/'
            ],
            'order_status_id' => 'integer|exists:order_statuses,id',
            'courier_id' => 'integer|exists:couriers,id|required_unless:order_status_id,1,null',
            'accepted_at' => 'date',
            'delivered_at' => 'date|required_if:order_status_id,3',
        ];
    }
}
