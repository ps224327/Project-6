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
        Schema::create('order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned(false);
            $table->string('status')->nullable(true);
            $table->unsignedInteger('user_id')->value(11)->unsigned(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('employee_number')->nullable();
            $table->integer('total_price')->unique(true);
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
