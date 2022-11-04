<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Imports\PlantProtectionProductsImport;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PlantProtectionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileUrl = 'D:\Semestr_6\Projekt_Inzynierski\plant_protection_products_seeder.xlsx';
        // $fileUrl = Storage::url('plantprotectionproducts/plant_protection_products_seeder.xlsx');
        // $fileUrl = Storage::url('plant_protection_products_seeder.xlsx');
        Excel::import(new PlantProtectionProductsImport, $fileUrl);
    }
}
