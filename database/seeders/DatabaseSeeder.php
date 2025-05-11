<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Faker\Factory;
use App\Models\User;
use App\Models\Plant;
use App\Models\Order;
use App\Models\OrderItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->resetDatabase();
        $this->seedUsers();
        $this->seedPlants();
    }

    private function resetDatabase(): void
    {
        DB::statement('SET CONSTRAINTS ALL DEFERRED;');

        OrderItem::truncate();
        Order::truncate();
        Plant::truncate();
        User::truncate();

        DB::statement('SET CONSTRAINTS ALL IMMEDIATE;');
    }

    private function seedUsers(): void
    {
        $faker = Factory::create('fr_FR');
        $file = base_path('users.txt');
        File::put($file, "=== ADMINS ===\n");

        for ($i = 1; $i <= 3; $i++) {
            $admin = User::create([
                'name' => $faker->name(),
                'email' => "admin{$i}@planteshop.com",
                'password' => Hash::make('password'),
                'admin' => true
            ]);
            File::append($file, "{$admin->email} password\n");
        }

        File::append($file, "\n=== USERS ===\n");

        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'admin' => false
            ]);
            File::append($file, "{$user->email} password\n");
        }
    }

    private function seedPlants(): void
    {
        $faker = Factory::create('fr_FR');
        $names = ['Rose', 'Tulipe', 'Lavande', 'Orchidée', 'Basilic', 'Menthe', 'Pivoine', 'Tournesol', 'Cactus', 'Bambou'];

        foreach (range(1, 30) as $i) {
            Plant::create([
                'name' => $names[$i % count($names)] . " $i",
                'description' => $faker->sentence(10),
                'price' => rand(5, 50),
                'stock' => rand(5, 30)
            ]);
        }
    }
}
