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
            $table->json('load_points');
            $table->json('unload_points');
            $table->double('price');
            $table->double('distance')->nullable();
            $table->dateTime('loading_time');
            $table->dateTime('unloading_time')->nullable();
            $table->string('loading_comment')->nullable();
            $table->string('unloading_comment')->nullable();
            // $table->json('valid_until');
            // $table->enum('load_type', ['верхняя', 'боковая', 'задняя'])->nullable();
            // $table->enum('unload_type', ['верхняя', 'боковая', 'задняя'])->nullable();
            // $table->text('comment')->nullable();
            $table->string('cargo_type')->nullable();
            $table->double('weight')->nullable();
            $table->double('length')->nullable();
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
