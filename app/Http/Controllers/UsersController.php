<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Affiche le profil d'un utilisateur.
     *
     * @param User $user Utilisateur a afficher
     * @return \Illuminate\View\View
     */
    public function show(User $user) {
        abort_unless(Auth::id() === $user->id, 403);
        return view('users.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'edition du profil.
     *
     * @param User $user Utilisateur a editer
     * @return \Illuminate\View\View
     */
    public function edit(User $user) {
        abort_unless(Auth::id() === $user->id, 403);
        return view('users.edit', compact('user'));
    }

    /**
     * Met a jour le profil d'un utilisateur.
     *
     * @param Request $request Requete HTTP
     * @param User $user Utilisateur a mettre a jour
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user) {
        abort_unless(Auth::id() === $user->id, 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', 'Profil mis à jour.');
    }
}
