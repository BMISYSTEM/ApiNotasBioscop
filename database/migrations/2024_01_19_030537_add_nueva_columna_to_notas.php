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
        Schema::table('notas', function (Blueprint $table) {
            $table->integer('reunion')->default(0);
            $table->integer('apuntamiento')->default(0);
            $table->integer('completado')->default(0);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->dropColumn('reunion');
            $table->dropColumn('apuntamiento');
            $table->dropColumn('completado');
        });
    }
};
