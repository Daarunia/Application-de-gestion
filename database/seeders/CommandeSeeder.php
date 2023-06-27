<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Commande;
use Carbon\Carbon;

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
        $date = Carbon::now();

        for ($i = 0; $i < 5; $i++) {
            Commande::create([
                'reference' => 'CMD-'.$faker->randomNumber(5),
                'total' => $faker->randomFloat(2, 8, 100),
                'status' => $faker->boolean,
                'date' => Carbon::create(2023, 6, 30)
            ]);
        }
    }
}

