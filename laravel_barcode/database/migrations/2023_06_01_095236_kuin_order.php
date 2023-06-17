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
        Schema::create('kuin_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned(false);
            $table->string('name')->nullable(true);
            $table->string('status')->nullable(true);
            $table->decimal('total_price')->nullable(true);
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
