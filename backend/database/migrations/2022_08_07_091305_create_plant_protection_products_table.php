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
        Schema::create('plant_protection_products', function (Blueprint $table) {
            $table->id();
            $table->string("name");                         //nazwa środka
            $table->string("permit_number");                //numer zezwolenia
            $table->date("permit_deadline");                //termin zezowlenia
            $table->date('sale_deadline');                  //termin do sprzedaży
            $table->date('term_for_use');                   //termin do użytku
            $table->json('type');                           //rodzaj
            $table->string('active_substance');             //substancja czynna
            $table->json('plant')->nullable();              //uprawa
            $table->json('pest')->nullable();               //agrofag
            $table->string('dose')->nullable();             //dawka
            $table->float('recommended_dose')->nullable();  //zalecana dawka
            $table->float('maximum_dose')->nullable();      //maksymalna dawka
            $table->string('unit')->nullable();             //jednostka [l/kg]
            $table->string('deadline')->nullable();         //termin
            $table->json('group_name');                     //nazwa grupy
            $table->string('small_area')->nullable();       //mało obszarowe
            $table->string('application')->nullable();      //zastosowanie/użytkownik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plant_protection_products');
    }
};
