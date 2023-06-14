<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Commande;
use App\Models\Service;


class ServiceCommande extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $commande = Commande::find(1);
        $service = Service::find(1);
        $commande->services()->attach($service, ['quantity' => 3]);

        $commande = Commande::find(1);
        $service = Service::find(2);
        $commande->services()->attach($service, ['quantity' => 8]);

        $commande = Commande::find(1);
        $service = Service::find(3);
        $commande->services()->attach($service, ['quantity' => 19]);

        $commande = Commande::find(1);
        $service = Service::find(4);
        $commande->services()->attach($service, ['quantity' => 16]);

        $commande = Commande::find(1);
        $service = Service::find(5);
        $commande->services()->attach($service, ['quantity' => 13]);
    }
}
