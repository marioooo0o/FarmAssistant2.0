<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Crop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crops')->insert([
            'name' => 'Ziemniak',
            'image_path' => 'crops/potato.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Gruszka',
            'image_path' => 'crops/pear.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Truskawka',
            'image_path' => 'crops/strawberry.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Kukurydza',
        ]);

        DB::table('crops')->insert([
            'name' => 'Soja',
            'image_path' => 'crops/peans.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Wiśnia',
            'image_path' => 'crops/cherries.png'
        ]);
        DB::table('crops')->insert([
            'name' => 'Pomidor',
            'image_path' => 'crops/tomato.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Sałata',
            'image_path' => 'crops/lettuce.png'
        ]);
        DB::table('crops')->insert([
            'name' => 'Ogórek',
            'image_path' => 'crops/cucumber.png'
        ]);
        DB::table('crops')->insert([
            'name' => 'Porzeczka czerwona',
        ]);

        DB::table('crops')->insert([
            'name' => 'Porzeczka czarna',
        ]);

        DB::table('crops')->insert([
            'name' => 'Papryka',
            'image_path' => 'crops/pepper.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Cebula',
            'image_path' => 'crops/onion.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Pszenica ozima',
        ]);

        DB::table('crops')->insert([
            'name' => 'Rzepak ozimy',
        ]);

        DB::table('crops')->insert([
            'name' => 'Jęczmień jary',
        ]);

        DB::table('crops')->insert([
            'name' => 'Cukinia',
        ]);
    }
}
