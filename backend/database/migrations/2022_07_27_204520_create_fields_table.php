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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farm_id');
            $table->unsignedBigInteger('crop_id');
            $table->string('field_name');
            $table->float('field_area')->default(0.00);
            $table->timestamps();
            $table->foreign('farm_id')
                ->references('id')
                ->on('farms')
                ->onDelete('cascade');
            $table->foreign('crop_id')
                ->references('id')
                ->on('crops')
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
        Schema::dropIfExists('fields');
    }
};
