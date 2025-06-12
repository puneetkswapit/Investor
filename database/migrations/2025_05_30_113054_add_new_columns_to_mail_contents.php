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
        Schema::table('mail_contents', function (Blueprint $table) {
            $table->renameColumn('content', 'content_1');
            $table->string('type')->nullable()->change();
            $table->longText('content_1')->nullable()->change();
            $table->longText('content_2')->nullable();
            $table->longText('content_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_contents', function (Blueprint $table) {
            //
        });
    }
};
