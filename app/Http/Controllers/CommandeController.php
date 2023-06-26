<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Commande;
use App\Models\Service;


class CommandeController extends Controller
{
    /**
     * Show the Commande view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = Service::all();
        $serviceController = new ServiceController();
        $serviceMapping = $serviceController->serviceMapping;

        // Use the mapping: if the current reference exists in the mapping, replace it with the corresponding nickname.
        foreach ($services as $service) {
            $reference = $service['reference'];
            foreach ($serviceMapping as $name => $references) {
                if (in_array($reference, $references)) {
                    $service['name'] = $name;
                }
            }
        }

        //To distinct services and avoid duplicates.
        $uniqueServiceNames = $services->pluck('name')->unique();

        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => $uniqueServiceNames,
        ]);
    }

    public function show($id)
    {
        $commande = Commande::findOrFail($id);
        return response()->json([
            'commande' => $commande,
            'services' => $commande->services()->get(),
        ]);
    }
}
