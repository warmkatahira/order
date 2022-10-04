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
        Schema::create('stock_history_details', function (Blueprint $table) {
            $table->bigIncrements('stock_history_detail_id');
            $table->unsignedbiginteger('stock_history_id');
            $table->string('operation_category');
            $table->string('operation_item_code');
            $table->string('operation_item_jan_code')->nullable();
            $table->string('operation_item_name');
            $table->integer('operation_quantity');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('stock_history_id')->references('stock_history_id')->on('stock_histories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_history_details');
    }
};
