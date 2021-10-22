<?php

namespace App\Models;

use Database\Factories\CourierFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema (
 *     schema="Courier",
 *     description="Courier model",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         description="Id курьера",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="credentials",
 *         description="ФИО",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         description="Телефон",
 *         type="string",
 *     ),
 *     @OA\Xml(
 *         name="Courier"
 *     )
 * )
 *
 * App\Models\Courier
 *
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @method static CourierFactory factory(...$parameters)
 * @property int $id
 * @property string $credentials ФИО
 * @property string $phone
 * @method static Builder|Courier whereCredentials($value)
 * @method static Builder|Courier whereId($value)
 * @method static Builder|Courier whereNumber($value)
 * @method static where(array $whereStatement)
 */
class Courier extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @param mixed|string|null $isFree
     *
     * @return self
     */
    public static function getCouriers($isFree = null): Collection
    {
        $whereStatement = [];
        is_null($isFree) ?: $whereStatement['free'] = $isFree;

        return Courier::where($whereStatement)->get();
    }

    public function scopeFree(Builder $query): Builder
    {
        return $query->whereHas('orders', fn (Builder $query) =>
            $query->where('order_status_id', array_search('delivered', OrderStatus::STATUSES)));
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
