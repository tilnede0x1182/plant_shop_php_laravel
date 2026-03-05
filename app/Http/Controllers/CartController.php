<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Contrôleur pour la gestion du panier.
 */
class CartController extends Controller
{
    /**
     * Affiche le panier de l'utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('carts.index');
    }
}
