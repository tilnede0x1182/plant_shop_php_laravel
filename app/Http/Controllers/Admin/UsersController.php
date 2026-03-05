<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Contrôleur admin pour la gestion des utilisateurs (CRUD).
 */
class UsersController extends Controller
{
	/**
	 * Affiche la liste des utilisateurs (admin).
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$users = User::orderBy('admin', 'desc')->orderBy('name')->get();
		return view('admin.users.index', compact('users'));
	}

	/**
	 * Affiche le détail d'un utilisateur.
	 *
	 * @param User $user Utilisateur à afficher
	 * @return \Illuminate\View\View
	 */
	public function show(User $user)
	{
		return view('admin.users.show', compact('user'));
	}

	/**
	 * Affiche le formulaire d'édition d'un utilisateur.
	 *
	 * @param User $user Utilisateur à éditer
	 * @return \Illuminate\View\View
	 */
	public function edit(User $user)
	{
		return view('admin.users.edit', compact('user'));
	}

	/**
	 * Met à jour un utilisateur.
	 *
	 * @param Request $request Requête HTTP
	 * @param User $user Utilisateur à mettre à jour
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, User $user)
	{
		$data = $request->validate([
			'name' => 'required|string',
			'email' => 'required|email',
		]);

		$data['admin'] = $request->has('admin');

		$user->update($data);
		return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour.');
	}

	/**
	 * Supprime un utilisateur.
	 *
	 * @param User $user Utilisateur à supprimer
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(User $user)
	{
		$user->delete();
		return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
	}
}
