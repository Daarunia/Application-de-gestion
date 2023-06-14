<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Commande;

class CommandeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            Commande::create([
                'reference' => 'CMD-'.$faker->randomNumber(5),
                'total' => $faker->randomFloat(2, 8, 100),
                'status' => $faker->boolean
            ]);
        }
    }
}

