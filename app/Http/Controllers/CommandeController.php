<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Commande;
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
            'services' => $serviceController->getNomServices(),
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
        $command = Commande::create([
            'total' => $validatedData['totalPrice'],
            'date' => $validatedData['commandDate'],
            'status' => true,
            'reference' => $newReference,
        ]);

        // Save the quantities in the pivot table
        //$categories = $request->input('categories');
        //foreach ($categories as $categoryId => $quantity) {
        //    $command->categories()->attach($categoryId, ['quantity' => $quantity]);
       // }

        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => $serviceController->getNomServices(),
        ]);
    }

    /**
     * Return the id of each service
     */
}
