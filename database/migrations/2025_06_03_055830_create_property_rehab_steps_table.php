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
        Schema::create('property_rehab_steps', function (Blueprint $table) {
            $table->id();
            $table->string('rehab_id');
            $table->integer('percentage');
            $table->string('title');
            $table->string('amount');
            $table->string('deadline');
            $table->text('summary');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rehab_steps');
    }
};
