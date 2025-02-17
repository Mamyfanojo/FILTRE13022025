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
        Schema::create('zone_5s', function (Blueprint $table) {
            $table->id();
            $table->string('flag')->nullable();
            $table->string('vessel_name')->nullable();
            $table->string('registered_owner')->nullable();
            $table->string('call_sign')->nullable();
            $table->string('mmsi')->nullable();
            $table->string('imo')->nullable();
            $table->string('ship_type')->nullable();
            $table->string('destination')->nullable();
            $table->string('eta')->nullable();
            $table->string('navigation_status')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('age')->nullable();
            $table->dateTime('time_of_fix');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_5s');
    }
};
