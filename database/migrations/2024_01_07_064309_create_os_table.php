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
        Schema::create('os', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',500);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('estado_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('os');
    }
};
