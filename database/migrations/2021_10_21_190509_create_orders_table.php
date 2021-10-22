<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('description')->comment('Описание');
            $table->string('coordinates')->comment('Координаты');
            $table->float('price')->comment('Цена');
            $table->foreignId('order_status_id')->comment('Статус')
                ->constrained('order_statuses')
                ->cascadeOnDelete();
            $table->foreignId('courier_id')->comment('Курьер')
                ->nullable()
                ->constrained('couriers')
                ->cascadeOnDelete();
            $table->timestamp('accepted_at')->comment('Дата принятия заказа')
                ->nullable();
            $table->timestamp('delivered_at')->comment('Дата доставки заказа')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
