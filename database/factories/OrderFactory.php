<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $status = OrderStatus::inRandomOrder()->first();
        $delivered  = $status->name === 'delivered';
        $delivering  = $status->name === 'delivering';

        return [
            'description' => $this->faker->realText(50),
            'coordinates' => rand(0, 100) . '.532071:' . rand(0, 100) . '.441036',
            'price' => rand(1000, 20000),
            'order_status_id' => $status->id,
            'courier_id' => $delivered || $delivering ? OrderStatus::inRandomOrder()->first()->id : null,
            'accepted_at' => $this->faker->dateTimeBetween('-1 month'),
            'delivered_at' => $delivered ? $this->faker->dateTimeBetween('-1 week') : null,
        ];
    }
}
