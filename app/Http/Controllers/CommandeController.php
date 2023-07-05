<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Commande;
use App\Http\Controllers\ServiceController;
use Error;

class CommandeController extends Controller
{
    /**
     * Show the Commande view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ServiceController $serviceController)
    {
        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => $serviceController->getNameServices(),
        ]);
    }

    public function destroy(ServiceController $serviceController, $id)
    {
        $commande = Commande::findOrFail($id);
        $commande->services()->detach();
        $commande->delete();

        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => $serviceController->getNameServices(),
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

    public function store(Request $request, ServiceController $serviceController)
    {
        $validatedData = $request->validate([
            'categories' => 'required|array',
            'totalPrice' => 'required|numeric',
            'commandDate' => 'required|date',
        ]);

        // Generate the new reference
        $lastReference = Commande::max('reference');
        if ($lastReference) {
            $referenceNumber = intval(substr($lastReference, 4)) + 1;
        } else {
            $referenceNumber = 1;
        }
        $newReference = 'CMD-' . str_pad($referenceNumber, 5, '0', STR_PAD_LEFT);

        // Create the new command
        $commande = Commande::create([
            'total' => $validatedData['totalPrice'],
            'date' => $validatedData['commandDate'],
            'status' => true,
            'reference' => $newReference,
        ]);

        // Add the quantity for each service in the pivot table for the current new command.
        foreach ($validatedData['categories'] as $key => $value) {
            $serviceId = $serviceController->getServicesId($value['name'], $value['quantity']);
            foreach ($serviceId as $id => $quantity) {
                $commande->services()->attach($id, ['quantity' => $quantity]);
            }
        }

        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => $serviceController->getNameServices(),
        ]);
    }

    /**
     * API function who fetch the data for the update command modal
     */
    public function getDataUpdate(ServiceController $serviceController, $id)
    {
        $commande = Commande::findOrFail($id);
        $services = $commande->services()->get();
        $commandeData = [];

        foreach ($services as $service) {
            $exceptionalCase = false;

            foreach ($serviceController->serviceMapping as $name => $references) {
                if (array_key_exists($service['reference'], $references)) {
                    if (isset($commandeData[$name])) {
                        $commandeData[$name] += $service['pivot']['quantity'];
                    } else {
                        $commandeData[$name] = $service['pivot']['quantity'];
                    }
                    $exceptionalCase = true;
                }
            }

            if (!$exceptionalCase) {
                $commandeData[$service['name']] = $service['pivot']['quantity'];
            }
        }

        return response()->json([
            'services' => $commandeData,
            'total' => $commande->total,
            'date' => $commande->date
        ]);
    }
}
