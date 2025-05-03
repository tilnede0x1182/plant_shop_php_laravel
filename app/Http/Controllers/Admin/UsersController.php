<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	public function index()
	{
		$users = User::orderBy('admin', 'desc')->get();
		return view('admin.users.index', compact('users'));
	}

	public function show(User $user)
	{
		return view('admin.users.show', compact('user'));
	}

	public function edit(User $user)
	{
		return view('admin.users.edit', compact('user'));
	}

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

	public function destroy(User $user)
	{
		$user->delete();
		return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
	}
}
