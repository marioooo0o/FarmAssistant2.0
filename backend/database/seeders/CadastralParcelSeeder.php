<?php

namespace Database\Seeders;

use App\Models\CadastralParcel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CadastralParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CadastralParcel::factory()->count(50)->create();
    }
}
