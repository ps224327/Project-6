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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(true);
            $table->integer('barcode');
            $table->string('description')->nullable(true);
            $table->decimal('price')->nullable(true);
            $table->string('image')->nullable(true);
            $table->string('color')->nullable(true);
            $table->integer('height_cm')->nullable(true);
            $table->integer('width_cm')->nullable(true);
            $table->integer('depth_cm')->nullable(true);
            $table->integer('weight_gr')->nullable(true);
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
