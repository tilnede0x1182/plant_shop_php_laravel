<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

/**
 * Contrôleur pour l'affichage des plantes (côté client).
 */
class PlantsController extends Controller
{
    /**
     * Affiche la liste des plantes disponibles.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
			return view('plants.index', ['plants' => Plant::where('stock', '>', 0)->orderBy('name')->get()]);
    }

    /**
     * Affiche le détail d'une plante.
     *
     * @param Plant $plant Plante à afficher
     * @return \Illuminate\View\View
     */
    public function show(Plant $plant)
    {
        return view('plants.show', ['plant' => $plant]);
    }
}
