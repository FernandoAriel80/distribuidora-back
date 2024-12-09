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
            $table->string('payment_id')->nullable();
            $table->decimal('total', 10, 2);
            $table->string('name');
            $table->string('last_name');
            $table->string('dni')->nullable();
            $table->string('email');
            $table->string('card_last_numb')->nullable();
            $table->string('type_card')->nullable();
            $table->string('card_name_user')->nullable();
            $table->timestamp('hour_and_date');
            $table->string('status');
            $table->string('delivery_status')->default('en revisión');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
