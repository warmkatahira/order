<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->unsignedBigInteger('order_user_id');
            $table->string('order_user_name');
            $table->string('store_pic');
            $table->date('order_date');
            $table->string('order_status');
            $table->date('delivery_date')->nullable();
            $table->unsignedBigInteger('delivery_time')->nullable();
            $table->string('shipping_store_name');
            $table->string('shipping_store_zip_code');
            $table->string('shipping_store_address_1');
            $table->string('shipping_store_address_2')->nullable();
            $table->string('shipping_store_tel_number')->nullable();
            $table->string('shipping_method');
            $table->string('order_comment')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('tracking_number')->nullable();
            $table->unsignedBigInteger('warehouse_pic_user_id')->nullable();
            $table->string('warehouse_pic_user_name')->nullable();
            $table->string('warehouse_comment')->nullable();
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
};
