<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Plant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $usersFile = base_path('users.txt');
        File::put($usersFile, "=== ADMINS ===\n");

        // Admins
        for ($i = 1; $i <= 3; $i++) {
            $admin = User::create([
                'name' => $faker->name(),
                'email' => "admin{$i}@planteshop.com",
                'password' => Hash::make('password'),
                'admin' => true
            ]);
            File::append($usersFile, "{$admin->email} password\n");
        }

        File::append($usersFile, "\n=== USERS ===\n");

        // Users
        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'admin' => false
            ]);
            File::append($usersFile, "{$user->email} password\n");
        }

        // Plantes
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
