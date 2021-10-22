<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @OA\Schema (
 *     schema="Order",
 *     description="Order model",
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
 *     @OA\Xml(
 *         name="Order"
 *     )
 * )
 *
 * App\Models\Order
 *
 * @property-read Courier $courier
 * @property-read OrderStatus $status
 * @method static OrderFactory factory(...$parameters)
 * @property int $id
 * @property string $description Описание
 * @property string $coordinates Координаты
 * @property float $price Цена
 * @property int $order_status_id Статус
 * @property int|null $courier_id Курьер
 * @property string $accepted_at Дата принятия заказа
 * @property string $delivered_at Дата доставки заказа
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Order whereAcceptedAt($value)
 * @method static Builder|Order whereCoordinates($value)
 * @method static Builder|Order whereCourierId($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDeliveredAt($value)
 * @method static Builder|Order whereDescription($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereOrderStatusId($value)
 * @method static Builder|Order wherePrice($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static create(array $all)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 * @method static where(array $array)
 */
class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'accepted_at' => 'date:Y-m-d',
        'delivered_at' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'description',
        'coordinates',
        'price',
        'order_status_id',
        'courier_id',
        'accepted_at',
        'delivered_at',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function (self $model) {
            $model->accepted_at ??= Carbon::now();
            $model->order_status_id ??= 1;
            if ($model->order_status_id === 3 && !$model->delivered_at) {
                $model->delivered_at = Carbon::now();
            }
        });
    }
}
