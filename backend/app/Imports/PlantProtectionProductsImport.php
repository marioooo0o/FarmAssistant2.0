<?php

namespace App\Imports;

use App\Models\PlantProtectionProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlantProtectionProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PlantProtectionProduct([
            'name' => $row['nazwa'],
            'permit_number' => $row['nrzezw'],
            'permit_deadline' => $row['terminzezw'],
            'sale_deadline' => $row['termindosprzedazy'],
            'term_for_use' => $row['termindostosowania'],
            'type' => $row['rodzaj'],
            'active_substance' => $row['substancja_czynna'],
            'plant' => $row['uprawa'],
            'pest' => $row['agrofag'],
            'dose' => $row['dawka'],
            'recommended_dose' => $row['zalecana'],
            'maximum_dose' => $row['maksymalna'],
            'unit' => $row['jednostka'],
            'deadline' => $row['termin'],
            'group_name' => $row['nazwa_grupy'],
            'small_area' => $row['maloobszarowe'],
            'application' => $row['zastosowanieuzytkownik'],
        ]);
    }
}
