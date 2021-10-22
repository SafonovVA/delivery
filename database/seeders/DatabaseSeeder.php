<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(OrderStatusSeeder::class);
        // \App\Models\User::factory(10)->create();
        \App\Models\Courier::factory(10)->create();
        \App\Models\Order::factory(50)->create();
    }
}
