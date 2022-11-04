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
        Schema::create('plant_protection_product_practise', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plant_protection_product_id');
            $table->unsignedBigInteger('practise_id');
            $table->float('quantity');
            $table->timestamps();
            $table->foreign('plant_protection_product_id', 'plantpp_id')
                ->references('id')
                ->on('plant_protection_products')
                ->onDelete('cascade');
            $table->foreign('practise_id')
                ->references('id')
                ->on('practises')
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
        Schema::dropIfExists('plant_protection_product_practise');
    }
};
