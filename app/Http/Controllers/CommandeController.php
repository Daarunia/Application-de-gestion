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
        return Inertia::render('Commande', [
            'commandes' => Commande::all(),
            'services' => Service::all()
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
