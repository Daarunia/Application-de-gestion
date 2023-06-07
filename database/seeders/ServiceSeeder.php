<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'reference' => 'DOU001',
            'name' => 'Ouverture de compte / Opening account',
            'price' => 30.00,
        ]);

        Service::create([
            'reference' => 'DOU002',
            'name' => 'Notification d\'un titre de transit',
            'price' => 25.00,
        ]);

        Service::create([
            'reference' => 'DOU003',
            'name' => 'Notification à partir du deuxième transit',
            'price' => 15.00,
        ]);

        Service::create([
            'reference' => 'DOU005',
            'name' => 'Frais de rechargement par coup de fourche',
            'price' => 50.00,
        ]);

        Service::create([
            'reference' => 'DOU006',
            'name' => 'Stockage : forfait de 48 h par palette',
            'price' => 15.00,
        ]);

        Service::create([
            'reference' => 'DOU014',
            'name' => 'Impression documents 1 à 10 pages',
            'price' => 10.00,
        ]);

        Service::create([
            'reference' => 'DOU015',
            'name' => 'Impression documents 11 à 20 pages',
            'price' => 5.00,
        ]);

        Service::create([
            'reference' => 'DOU016',
            'name' => 'Impression document > 20 pages / page',
            'price' => 0.50,
        ]);
    }
}
