<?php

use Illuminate\Database\Seeder;

class GouvernoratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $gouvernorats=[
            "Ariana",
            "Béja",
            "Ben Arous",
            "Bizerte",
            "Gabès",
            "Gafsa",
            "Jendouba",
            "Kairouan",
            "Kasserine",
            "Kébili",
            "Kef",
            "Mahdia",
            "Manouba",
            "Médenine",
            "Monastir",
            "Nabeul",
            "Sfax",
            "Sidi Bouzid",
            "Siliana",
            "Sousse",
            "Tataouine",
            "Tozeur",
            "Tunis",
            "Zaghouan",
        ];
        foreach($gouvernorats as $gouv){
            DB::table('gouvernorats')->insert([
                'name' => $gouv,
            ]);
        }
    }
}
