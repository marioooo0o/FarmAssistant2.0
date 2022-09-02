<?php

namespace App\Imports;

use App\Models\PlantProtectionProduct;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlantProtectionProductsImport implements ToModel, WithHeadingRow
{
    private function getIds($array)
    {
        $newArray = array();

        foreach ($array as $key => $value) {
            if (is_numeric($value)) {
                array_push($newArray, $value);
            }
        }
        return $newArray;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $pPProduct = new PlantProtectionProduct;
            $pPProduct->name = $row['nazwa'];
            $pPProduct->permit_number = $row['nrzezw'];
            if (is_string($row['terminzezw'])) {
                echo ($row);
            }
            if (is_string($row['termindosprzedazy'])) {
                echo ($row);
            }
            if (is_string($row['termindostosowania'])) {
                echo ($row);
            }
            $pPProduct->permit_deadline = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['terminzezw'])->format('Y-m-d');
            $pPProduct->sale_deadline = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['termindosprzedazy'])->format('Y-m-d');
            $pPProduct->term_for_use = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$row['termindostosowania'])->format('Y-m-d');
            $pPProduct->type = $row['rodzaj'];
            $pPProduct->active_substance = $row['substancja_czynna'];
            $pPProduct->pest = $row['agrofag'];
            $pPProduct->dose = $row['dawka'];
            $pPProduct->maximum_dose = $row['maksymalna'];
            $pPProduct->unit = $row['jednostka'];
            $pPProduct->deadline = $row['termin'];
            $pPProduct->group_name = $row['nazwa_grupy'];
            $pPProduct->small_area = $row['maloobszarowe'];
            $pPProduct->application = $row['zastosowanieuzytkownik'];

            $pPProduct->save();

            $cropsId = $this->getIds(explode(", ", $row['uprawa']));

            $pPProduct->crops()->attach($cropsId);

            return $pPProduct;
        } catch (Exception $e) {
            throw $e;
        }



        // return new PlantProtectionProduct([
        //     'name' => $row['nazwa'],
        //     'permit_number' => $row['nrzezw'],
        //     'permit_deadline' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['terminzezw'])->format('Y-m-d'),
        //     'sale_deadline' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['termindosprzedazy'])->format('Y-m-d'),
        //     'term_for_use' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['termindostosowania'])->format('Y-m-d'),
        //     'type' => $row['rodzaj'],
        //     'active_substance' => $row['substancja_czynna'],
        //     'plant' => $row['uprawa'],
        //     'pest' => $row['agrofag'],
        //     'dose' => $row['dawka'],
        //     'recommended_dose' => $row['zalecana'],
        //     'maximum_dose' => $row['maksymalna'],
        //     'unit' => $row['jednostka'],
        //     'deadline' => $row['termin'],
        //     'group_name' => $row['nazwa_grupy'],
        //     'small_area' => $row['maloobszarowe'],
        //     'application' => $row['zastosowanieuzytkownik'],
        // ]);
    }
}
