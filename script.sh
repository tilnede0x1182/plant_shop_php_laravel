#!/bin/bash

mkdir -p app/Http/Controllers/Admin

# app/Http/Controllers/UsersController.php
cat > app/Http/Controllers/UsersController.php <<'EOF'
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
EOF

# app/Http/Controllers/OrdersController.php
cat > app/Http/Controllers/OrdersController.php <<'EOF'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plant;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index() {
        $orders = Auth::user()->orders()->with('orderItems.plant')->get();
        return view('orders.index', compact('orders'));
    }

    public function create() {
        return view('orders.new');
    }

    public function store(Request $request) {
        $items = json_decode($request->input('order.items'), true);
        $total = 0;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'confirmed',
                'total_price' => 0,
            ]);

            foreach ($items as $item) {
                $plant = Plant::findOrFail($item['plant_id']);
                $qty = intval($item['quantity']);

                if ($plant->stock < $qty) {
                    throw new \Exception("Stock insuffisant pour {$plant->name}");
                }

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
            return redirect()->route('orders.index')->with('success', 'Commande confirmée.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.create')->with('error', $e->getMessage());
        }
    }
}
EOF

# app/Http/Controllers/Admin/UsersController.php
cat > app/Http/Controllers/Admin/UsersController.php <<'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $users = User::orderBy('admin', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user) {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'admin' => 'boolean',
        ]);

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }
}
EOF

# app/Http/Controllers/Controller.php (ApplicationController)
cat > app/Http/Controllers/Controller.php <<'EOF'
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
EOF
