<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantsController extends Controller
{
    public function index()
    {
			return view('plants.index', ['plants' => Plant::where('stock', '>', 0)->orderBy('name')->get()]);
    }

    public function show(Plant $plant)
    {
        return view('plants.show', ['plant' => $plant]);
    }
}
