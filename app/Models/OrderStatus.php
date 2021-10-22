<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema (
 *     schema="OrderStatus",
 *     description="Order status model",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         description="Id статуса",
 *         type="integer",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         description="Название",
 *         type="string",
 *     ),
 *     @OA\Xml(
 *         name="OrderStatus"
 *     )
 * )
 *
 * App\Models\OrderStatus
 *
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property int $id
 * @property string $name Название
 * @method static Builder|OrderStatus whereId($value)
 * @method static Builder|OrderStatus whereName($value)
 * @method static inRandomOrder()
 * @method static find(mixed $get)
 * @method static updateOrCreate(array $array)
 */
class OrderStatus extends Model
{
    use HasFactory;

    public const STATUSES = [
        1 => 'accepted',
        2 => 'delivering',
        3 => 'delivered',
    ];

    public $timestamps = false;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
