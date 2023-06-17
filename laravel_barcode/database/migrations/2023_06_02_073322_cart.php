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
        Schema::create('cart', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned(false);
            $table->unsignedInteger('product_id')->value(11)->unsigned(false);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('user_id')->value(11)->unsigned(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('quantity')->nullable(false);
            $table->timestamps();

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
