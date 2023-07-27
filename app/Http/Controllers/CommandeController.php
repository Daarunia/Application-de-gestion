<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Commande;
use App\Models\Service;
use App\Http\Controllers\ServiceController;

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

    public function update(Request $request, ServiceController $serviceController, $id)
    {
        $serviceMapping = $serviceController->serviceMapping;

        $validatedData = $request->validate([
            'categories' => 'required|array',
            'date' => 'required|date',
            'totalPrice' => 'required|numeric',
            'status' => 'required|boolean'
        ]);

        // Commande data
        $commande = Commande::find($id);
        $commande->date = $validatedData['date'];
        $commande->total = $validatedData['totalPrice'];
        $commande->status = $validatedData['status'];
        $commande->save();

        // Services data
        foreach ($validatedData['categories'] as $key => $value) {
            $serviceId = $serviceController->getServicesId($key, $value['quantity']);
            // Exceptional cases
            if (array_key_exists($key, $serviceMapping)) {
                // delete the old service data
                foreach ($serviceMapping as $name => $references) {
                    foreach ($references as $reference => $maxAllowedQuantity) {
                        if ($name === $key) {
                            $service = Service::where('reference', $reference)->first();
                            $commande->services()->detach($service->id);
                        }
                    }
                }
                //Add the quantity for each service in the pivot table for the current command.
                foreach ($serviceId as $id => $quantity) {
                    if($quantity > 0){
                        $commande->services()->attach($id, ['quantity' => $quantity]);
                    }
                }
            } else {
                // Update the date for non-exceptional cases
                $service = Service::where('name', $key)->first();
                $commande->services()->detach($service->id);

                if($value['quantity'] > 0){
                    $commande->services()->attach($service->id, ['quantity' => $value['quantity']]);
                }
            }
        }

        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => $serviceController->getNameServices(),
        ]);
    }

    public function store(Request $request, ServiceController $serviceController)
    {
        $validatedData = $request->validate([
            'categories' => 'required|array',
            'totalPrice' => 'required|numeric',
            'commandDate' => 'required|date',
            'status' => 'required|boolean'
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
            'status' => $validatedData['status'],
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
                $data = [];
                if (array_key_exists($service['reference'], $references)) {
                    if (isset($commandeData[$name])) {
                        $commandeData[$name]['quantity'] += $service['pivot']['quantity'];
                        $response = $serviceController->getPrice($name, $commandeData[$name]['quantity']);
                        $priceData = $response->getData();
                        $commandeData[$name]['price'] = $priceData->price;
                    } else {
                        $response = $serviceController->getPrice($service['name'], $service['pivot']['quantity']);
                        $priceData = $response->getData();
                        $data['price'] = $priceData->price;
                        $data['quantity'] = $service['pivot']['quantity'];
                        $commandeData[$name] = $data;
                    }
                    $exceptionalCase = true;
                }
            }

            if (!$exceptionalCase) {
                $response = $serviceController->getPrice($service['name'], $service['pivot']['quantity']);
                $priceData = $response->getData();
                $data['price'] = $priceData->price;
                $data['quantity'] = $service['pivot']['quantity'];
                $commandeData[$service['name']] =  $data;
            }
        }

        return response()->json([
            'services' => $commandeData,
            'date' => $commande->date,
            'id' => $commande->id,
            'status' => $commande-> status
        ]);
    }
}
