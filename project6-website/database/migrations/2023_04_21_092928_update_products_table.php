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
        Schema::table('products', function (Blueprint $table) {
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->string('color');
            $table->integer('height_cm');
            $table->integer('width_cm');
            $table->integer('depth_cm');
            $table->integer('weight_gr');
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
