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
            'image_path' => 'crops/uoCoI5mUQ5sUhsffnQsfpl1dNY88viUh9ymNGlGp.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Gruszka',
            'image_path' => 'crops/4gFr51sJIDdKKbrX9YymSxjoIcgLXxythsWUbiCN.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Truskawka',
            'image_path' => 'crops/OWnLZnSvebEDBY9Z6FSHDCntp0yjSghdnTGAVqhH.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Kukurydza',
        ]);

        DB::table('crops')->insert([
            'name' => 'Soja',
            'image_path' => 'crops/k3xi9g8N0TmkkbWsDegcOsoMB5zAnrwdJjHlubBr.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Wiśnia',
            'image_path' => 'crops/MCFmHa8UlGRuRxXUggXzrbyLry1929ESbXejkBoX.png'
        ]);
        DB::table('crops')->insert([
            'name' => 'Pomidor',
            'image_path' => 'crops/7pPA9ygvNcLyRdzs0nOVzk39wVqumLdiz1CBjjZF.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Sałata',
            'image_path' => 'crops/0UO32weEArP09NE9qYdePNaV0sVFWWrHMHwhbKzB.png'
        ]);
        DB::table('crops')->insert([
            'name' => 'Ogórek',
            'image_path' => 'crops/qLzVh8ij0MvO71BrizLUTBua7XnMqdUaSJRcTjit.png'
        ]);
        DB::table('crops')->insert([
            'name' => 'Porzeczka czerwona',
        ]);

        DB::table('crops')->insert([
            'name' => 'Porzeczka czarna',
        ]);

        DB::table('crops')->insert([
            'name' => 'Papryka',
            'image_path' => 'crops/HWmP1jE54YobyvCEZ51grs3kQlQEr2QlRDoa9dux.png'
        ]);

        DB::table('crops')->insert([
            'name' => 'Cebula',
            'image_path' => 'crops/3dGSZEAGwEJ32rnTA8eVAFaov7uSsvJ9Ld9gNCE1.png'
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
