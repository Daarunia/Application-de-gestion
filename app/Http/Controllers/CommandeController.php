<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CommandeController extends Controller
{
    /**
     * Show the Commande view
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return Inertia::render('Commande',[
            'name' => 'Maxime'
        ]);
    }
}
