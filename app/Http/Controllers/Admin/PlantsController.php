<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantsController extends Controller
{
	public function index()
	{
		return view('admin.plants.index', ['plants' => Plant::orderBy('name')->get()]);
	}

	public function create()
	{
		return view('admin.plants.create', ['plant' => new Plant()]);
	}

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

	public function edit(Plant $plant)
	{
		return view('admin.plants.edit', ['plant' => $plant]);
	}

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

	public function destroy(Plant $plant)
	{
		$plant->delete();
		return redirect()->route('admin.plants.index');
	}
}
