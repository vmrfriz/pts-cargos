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
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('route');
            $table->double('kilometrage');
            $table->double('price');
            $table->dateTime('loading_time')->nullable();
            $table->dateTime('unloading_time')->nullable();
            $table->json('load_worktime')->nullable();
            $table->json('unload_worktime')->nullable();
            $table->json('valid_until');
            $table->enum('load_type', ['верхняя', 'боковая', 'задняя'])->nullable();
            $table->enum('unload_type', ['верхняя', 'боковая', 'задняя'])->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
