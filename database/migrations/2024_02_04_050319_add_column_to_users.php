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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido');
            $table->boolean('activo');
            $table->bigInteger('id_rol')->unsigned();
            $table->bigInteger('id_area')->unsigned();
            $table->foreign('id_rol')->references('id')->on('rols');
            $table->foreign('id_area')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('apellido');
            $table->dropColumn('activo');
            $table->dropColumn('id_rol');
            $table->dropColumn('id_area');
        });
    }
};
