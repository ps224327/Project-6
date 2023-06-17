<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kuin_product_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned(false);
            $table->unsignedInteger('product_id')->value(11)->unsigned(false);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('order_id')->value(11)->unsigned(false);
            $table->foreign('order_id')->references('id')->on('kuin_order')->onDelete('cascade');
            $table->integer('amount')->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
