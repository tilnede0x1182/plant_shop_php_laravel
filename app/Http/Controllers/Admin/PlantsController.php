<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;

/**
 * Contrôleur admin pour la gestion des plantes (CRUD).
 */
class PlantsController extends Controller
{
	/**
	 * Affiche la liste des plantes (admin).
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('admin.plants.index', ['plants' => Plant::orderBy('name')->get()]);
	}

	/**
	 * Affiche le formulaire de création d'une plante.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('admin.plants.create', ['plant' => new Plant()]);
	}

	/**
	 * Enregistre une nouvelle plante.
	 *
	 * @param Request $request Requête HTTP
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		$plant = Plant::create($request->validate([
			'name' => 'required|string',
			'price' => 'required|integer',
			'description' => 'nullable|string',
			'stock' => 'required|integer',
		]));
		return redirect()->route('admin.plants.index');
	}

	/**
	 * Affiche le formulaire d'édition d'une plante.
	 *
	 * @param Plant $plant Plante à éditer
	 * @return \Illuminate\View\View
	 */
	public function edit(Plant $plant)
	{
		return view('admin.plants.edit', ['plant' => $plant]);
	}

	/**
	 * Met à jour une plante.
	 *
	 * @param Request $request Requête HTTP
	 * @param Plant $plant Plante à mettre à jour
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Plant $plant)
	{
		$plant->update($request->validate([
			'name' => 'required|string',
			'price' => 'required|integer',
			'description' => 'nullable|string',
			'stock' => 'required|integer',
		]));
		return redirect()->route('admin.plants.index');
	}

	/**
	 * Supprime une plante.
	 *
	 * @param Plant $plant Plante à supprimer
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Plant $plant)
	{
		$plant->delete();
		return redirect()->route('admin.plants.index');
	}
}
