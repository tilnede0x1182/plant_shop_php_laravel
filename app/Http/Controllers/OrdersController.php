<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plant;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
	public function index()
	{
		$orders = Auth::user()->orders()->with('orderItems.plant')->get()->each(function ($order) {
			$order->items = $order->orderItems;
		});
		return view('orders.index', compact('orders'));
	}

	public function create()
	{
		return view('orders.new');
	}

	public function store(Request $request)
	{
		$items = json_decode($request->input('items'), true);
		$total = 0;

		try {
			DB::beginTransaction();

			// Valider les stocks d'abord
			foreach ($items as $item) {
				$plant = Plant::findOrFail($item['plant_id']);
				$qty = intval($item['quantity']);

				if ($plant->stock < $qty) {
					DB::rollBack();
					return redirect()
						->route('orders.create')
						->with('error', "Stock insuffisant pour {$plant->name}")
						->with('stock_adjust', ['id' => $plant->id, 'available' => $plant->stock]);
				}
			}

			// Création après validation
			$order = Order::create([
				'user_id' => Auth::id(),
				'status' => 'confirmed',
				'total_price' => 0,
			]);

			// Traitement des items
			foreach ($items as $item) {
				$plant = Plant::findOrFail($item['plant_id']);
				$qty = intval($item['quantity']);

				$plant->decrement('stock', $qty);
				OrderItem::create([
					'order_id' => $order->id,
					'plant_id' => $plant->id,
					'quantity' => $qty,
				]);

				$total += $plant->price * $qty;
			}

			$order->update(['total_price' => $total]);

			DB::commit();
			return redirect()->route('orders.create')->with('success', true);
		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()
				->route('orders.create')
				->with('error', "Erreur commande : " . $e->getMessage());
		}
	}
}
