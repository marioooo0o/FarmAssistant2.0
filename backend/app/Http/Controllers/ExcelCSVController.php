<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PlantProtectionProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelCSVController extends Controller
{
    public function importExcelCSV()
    {
        $fileUrl = 'D:\Semestr_6\Projekt_Inzynierski\import.xlsx';

        Excel::import(new PlantProtectionProductsImport, $fileUrl);
        return 'udało się';
    }
}
