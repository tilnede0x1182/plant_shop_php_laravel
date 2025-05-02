<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function show(User $user) {
        abort_unless(Auth::id() === $user->id, 403);
        return view('users.show', compact('user'));
    }

    public function edit(User $user) {
        abort_unless(Auth::id() === $user->id, 403);
        return view('users.edit', compact('user'));
    }

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
