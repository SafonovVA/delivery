<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UpdateOrderRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         type="object",
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
 * @property int $courier_id
 * @property int $order_status_id
 */
class UpdateOrderRequest extends FormRequest
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
            'order_status_id' => 'integer|exists:order_statuses,id',
            'courier_id' => 'integer|exists:couriers,id'
        ];
    }
}
