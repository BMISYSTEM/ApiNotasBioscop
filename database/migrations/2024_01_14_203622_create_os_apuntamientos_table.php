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
        Schema::create('os_apuntamientos', function (Blueprint $table) {
            $table->id();
            $table->string('nota',500);
            $table->date('fecha');
            $table->time('hora');
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_os')->unsigned();
            $table->bigInteger('id_estado')->unsigned();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_os')->references('id')->on('os');
            $table->foreign('id_estado')->references('id')->on('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('os_apuntamientos');
    }
};
