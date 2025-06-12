<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property_rehabs', function (Blueprint $table) {
            $table->id();
            $table->string('rehab_id')->unique();
            $table->string('property_id');
            $table->string('reason');
            $table->string('other_reason')->nullable();
             $table->integer('percentage')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rehabs');
    }
};
