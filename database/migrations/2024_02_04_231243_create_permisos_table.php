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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_rol')->unsigned();
            $table->boolean('home')->default(true);
            $table->boolean('project')->default(true);
            $table->boolean('os')->default(true);
            $table->boolean('permisos')->default(true);
            $table->boolean('sharepoint')->default(true);
            $table->boolean('intinerario')->default(true);
            $table->boolean('docs')->default(true);
            $table->boolean('configuracion')->default(true);
            $table->foreign('id_rol')->references('id')->on('rols');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
