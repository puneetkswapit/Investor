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
    Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->string('property_id')->unique();
        $table->string('name');
        $table->string('subtitle')->nullable();
        $table->string('closedate')->nullable();
        $table->string('yearbuilt')->nullable();
        $table->string('location');
        $table->string('equityraise')->nullable();
        $table->string('minimuminvestment')->nullable();
        $table->string('unit')->nullable();
        $table->string('occupancy')->nullable();
        $table->string('rehabrepairs')->nullable();
        $table->text('description')->nullable();
        $table->float('generalpartnershare')->nullable();
        $table->float('investorshare')->nullable();
        $table->string('website_url')->nullable();

        // Value fields
        $table->string('purchaseprice')->nullable();
        $table->string('valueasrenovated')->nullable();
        $table->string('noiamount')->nullable();
        $table->string('noidescription')->nullable();

        // Loan Details
        $table->string('lender')->nullable();
        $table->string('loanamount')->nullable();
        $table->string('typeofloan')->nullable();
        $table->string('loanterm')->nullable();
        $table->string('interestrate')->nullable();
        $table->string('interestonly')->nullable();
        $table->string('interestonlyexpires')->nullable();
        $table->string('annualdebtservices1')->nullable();
        $table->string('interestonlyamount')->nullable();
        $table->string('annualdebtservices2')->nullable();
        $table->string('amortizedamount')->nullable();

        // Asset Managers
        $table->string('asset_manager_line1')->nullable();
        $table->string('asset_manager_line2')->nullable();
        $table->string('asset_manager_line3')->nullable();

        // Ownership Entity
        $table->string('ownership_entity_line1')->nullable();
        $table->string('ownership_entity_line2')->nullable();
        $table->string('ownership_entity_line3')->nullable();

        // Notes and iframe
        $table->text('property_note')->nullable();
        $table->text('property_iframe')->nullable();

        // Category and subcategory (assuming integer ids)
        $table->unsignedBigInteger('category')->nullable();
        $table->text('sub_category')->nullable();
        $table->string('slug')->nullable();
        $table->boolean('status')->nullable();
        $table->integer('order')->default(0);
        // For subcategory, since multiple can be selected, you typically store this in a separate pivot table

        // Image path or filename
        $table->string('property_image')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
