<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Imports\PlantProtectionProductsImport;
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
        $fileUrl = 'D:\Semestr_6\Projekt_Inzynierski\import.xlsx';

        Excel::import(new PlantProtectionProductsImport, $fileUrl);
    }
}
