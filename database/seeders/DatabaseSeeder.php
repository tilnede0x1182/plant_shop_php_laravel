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
	// Variables globales pour la seed
	const NB_ADMINS = 3;  // 👤 Nombre d'administrateurs à créer
	const NB_USERS = 20;  // 👥 Nombre d'utilisateurs à créer
	const NB_PLANTES = 30; // 🌱 Nombre de plantes à créer

	private array $nomsPlantes = [
		"Rose", "Tulipe", "Lavande", "Orchidée", "Basilic", "Menthe", "Pivoine", "Tournesol",
		"Cactus (Echinopsis)", "Bambou", "Camomille (Matricaria recutita)", "Sauge (Salvia officinalis)",
		"Romarin (Rosmarinus officinalis)", "Thym (Thymus vulgaris)", "Laurier-rose (Nerium oleander)",
		"Aloe vera", "Jasmin (Jasminum officinale)", "Hortensia (Hydrangea macrophylla)",
		"Marguerite (Leucanthemum vulgare)", "Géranium (Pelargonium graveolens)", "Fuchsia (Fuchsia magellanica)",
		"Anémone (Anemone coronaria)", "Azalée (Rhododendron simsii)", "Chrysanthème (Chrysanthemum morifolium)",
		"Digitale pourpre (Digitalis purpurea)", "Glaïeul (Gladiolus hortulanus)", "Lys (Lilium candidum)",
		"Violette (Viola odorata)", "Muguet (Convallaria majalis)", "Iris (Iris germanica)",
		"Lavandin (Lavandula intermedia)", "Érable du Japon (Acer palmatum)", "Citronnelle (Cymbopogon citratus)",
		"Pin parasol (Pinus pinea)", "Cyprès (Cupressus sempervirens)", "Olivier (Olea europaea)",
		"Papyrus (Cyperus papyrus)", "Figuier (Ficus carica)", "Eucalyptus (Eucalyptus globulus)",
		"Acacia (Acacia dealbata)", "Bégonia (Begonia semperflorens)", "Calathea (Calathea ornata)",
		"Dieffenbachia (Dieffenbachia seguine)", "Ficus elastica", "Sansevieria (Sansevieria trifasciata)",
		"Philodendron (Philodendron scandens)", "Yucca (Yucca elephantipes)", "Zamioculcas zamiifolia",
		"Monstera deliciosa", "Pothos (Epipremnum aureum)", "Agave (Agave americana)", "Cactus raquette (Opuntia ficus-indica)",
		"Palmier-dattier (Phoenix dactylifera)", "Amaryllis (Hippeastrum hybridum)", "Bleuet (Centaurea cyanus)",
		"Cœur-de-Marie (Lamprocapnos spectabilis)", "Croton (Codiaeum variegatum)", "Dracaena (Dracaena marginata)",
		"Hosta (Hosta plantaginea)", "Lierre (Hedera helix)", "Mimosa (Acacia dealbata)"
	];

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
		for ($i = 1; $i <= self::NB_ADMINS; $i++) {
			$admin = User::create([
				'name' => $faker->name(),
				'email' => "admin{$i}@planteshop.com",
				'password' => Hash::make('password'),
				'admin' => true
			]);
			File::append($file, "{$admin->email} password\n");
		}
		File::append($file, "\n=== USERS ===\n");
		for ($i = 1; $i <= self::NB_USERS; $i++) {
			$user = User::create([
				'name' => $faker->name(),
				'email' => $faker->unique()->safeEmail(),
				'password' => Hash::make('password'),
				'admin' => false
			]);
			File::append($file, "{$user->email} password\n");
		}
	}

	/**
	 * Retourne le nom de la plante selon la logique Ruby/Rails
	 * @param int $iterator Index de création (commence à 0)
	 * @return string
	 */
	private function getPlantName(int $iterator): string
	{
		$noms = $this->nomsPlantes;
		$taille = count($noms);
		if (self::NB_PLANTES > $taille) {
			return $noms[$iterator % $taille] . ' ' . (intdiv($iterator, $taille) + 1);
		}
		return $noms[$iterator % $taille];
	}

	private function seedPlants(): void
	{
		$faker = Factory::create('fr_FR');
		for ($iterator = 0; $iterator < self::NB_PLANTES; $iterator++) {
			Plant::create([
				'name' => $this->getPlantName($iterator),
				'description' => $faker->sentence(10),
				'price' => rand(5, 50),
				'stock' => rand(5, 30)
			]);
		}
	}
}
