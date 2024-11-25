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
            $table->unsignedBigInteger('user_id');
            $table->json('products'); // Detalles de los productos
            $table->string('status')->default('pending'); // Estado del pago
            $table->string('payment_id')->nullable(); // ID del pago en Mercado Pago
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
