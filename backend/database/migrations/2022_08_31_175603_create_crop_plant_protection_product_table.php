<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crop_plant_protection_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crop_id');
            $table->unsignedBigInteger('plant_protection_product_id');
            $table->timestamps();
            $table->foreign('crop_id')
                ->references('id')
                ->on('crops')
                ->onDelete('cascade');
            $table->foreign('plant_protection_product_id', 'ppproduct_id')
                ->references('id')
                ->on('plant_protection_products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crop_plant_protection_product');
    }
};
