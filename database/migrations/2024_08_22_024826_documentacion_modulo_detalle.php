<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    // id:v4(),
    //       module: 1,
    //       position: 1,
    //       type: 4, //alerta
    //       title: title,
    //       image:imagen,
    //       text: '',
    public function up(): void
    {
        Schema::create('documentacion_modulos_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('posicion');
            $table->integer('tipo');
            $table->string('title',1000);
            $table->string('image',1000);
            $table->text('text');
            $table->bigInteger('id_modulo')->unsigned();
            $table->foreign('id_modulo')->references('id')->on('documentacion_modulos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentacion_modulos_detalles');
    }
};
