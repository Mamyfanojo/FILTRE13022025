<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('avurnavs', function (Blueprint $table) {
            $table->id();
            $table->string('avurnav_local');
            $table->string('ile');
            $table->string('vous_signale');
            $table->string('position');
            $table->string('navire');
            $table->integer('pob');
            $table->string('type');
            $table->string('caracteristiques');
            $table->string('zone');
            $table->date('derniere_communication');
            $table->string('contacts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avurnavs');
    }
};
