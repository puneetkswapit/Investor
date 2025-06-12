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
        Schema::create('rehab_images', function (Blueprint $table) {
            $table->id();
            $table->string('rehab_id');
            $table->bigInteger('step_id')->unsigned()->index()->nullable();
            $table->foreign('step_id')->references('id')->on('property_rehab_steps')->onDelete('cascade');
            $table->string('image');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rehab_images');
    }
};
