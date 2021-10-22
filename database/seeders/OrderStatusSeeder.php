<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (OrderStatus::STATUSES as $status) {
            OrderStatus::updateOrCreate(['name' => $status]);
        }
    }
}
