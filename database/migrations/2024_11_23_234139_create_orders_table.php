<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique(); // ID de la compra generada por Mercado Pago
            $table->unsignedBigInteger('user_id')->nullable(); // ID del usuario
            $table->json('products'); // Información de los productos comprados
            $table->decimal('total', 10, 2); // Monto total de la compra
            $table->string('status')->default('pending'); // Estado del pago (pending, approved, failed)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
