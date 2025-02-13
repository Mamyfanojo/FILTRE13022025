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
        Schema::create('sitreps', function (Blueprint $table) {
            $table->id();
            $table->string('sitrep_sar');
            $table->string('mrcc_madagascar');
            $table->string('event');
            $table->string('position');
            $table->string('situation');
            $table->string('number_of_persons');
            $table->string('assistance_required');
            $table->string('coordinating_rcc');
            $table->string('initial_action_taken');
            $table->text('chronology');
            $table->text('additional_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitreps');
    }
};
