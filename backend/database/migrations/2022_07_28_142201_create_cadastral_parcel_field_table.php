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
        Schema::create('cadastral_parcel_field', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cadastral_parcel_id');
            $table->unsignedBigInteger('field_id');
            $table->float('area');
            $table->timestamps();
            $table->foreign('cadastral_parcel_id')
                ->references('id')
                ->on('cadastral_parcels')
                ->onDelete('cascade');
            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
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
        Schema::dropIfExists('cadastral_parcel_field');
    }
};
