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
        Schema::create('coffee_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('product', ['gold-coffee', 'arabic-coffee']);
            $table->integer('quantity');
            $table->double('unit_cost',8,2);
            $table->double('selling_price',8,2);
            $table->double('profile_margin',8,2)->nullable();
            $table->double('shipping_cost',8,2)->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coffee_sales');
    }
};
