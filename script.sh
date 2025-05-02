# 3 – Modèles + migrations ─────────────────────────────────────────
php artisan make:model Plant      -m
php artisan make:model Order      -m
php artisan make:model OrderItem  -m
php artisan make:migration add_admin_and_name_to_users --table=users

# ── ./database/migrations/*create_plants_table.php
cat > $(ls database/migrations/*create_plants_table.php) <<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(){
        Schema::create('plants',function(Blueprint $t){
            $t->id();
            $t->string('name');
            $t->integer('price');
            $t->text('description')->nullable();
            $t->integer('stock');
            $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('plants'); }
};
PHP
# WHY: reproduit table plants de Rails.

# ── ./database/migrations/*create_orders_table.php
cat > $(ls database/migrations/*create_orders_table.php) <<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(){
        Schema::create('orders',function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->integer('total_price')->default(0);
            $t->string('status');
            $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('orders'); }
};
PHP
# WHY: idem table orders.

# ── ./database/migrations/*create_order_items_table.php
cat > $(ls database/migrations/*create_order_item*s_table.php) <<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(){
        Schema::create('order_items',function(Blueprint $t){
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('plant_id')->constrained()->cascadeOnDelete();
            $t->integer('quantity');
            $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('order_items'); }
};
PHP
# WHY: idem table order_items.

# ── ./database/migrations/*add_admin_and_name_to_users.php
cat > $(ls database/migrations/*add_admin_and_name_to_users.php) <<'PHP'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(){
        Schema::table('users',function(Blueprint $t){
            $t->boolean('admin')->default(false);
            $t->string('name')->nullable();
        });
    }
    public function down(){
        Schema::table('users',function(Blueprint $t){
            $t->dropColumn(['admin','name']);
        });
    }
};
PHP
# WHY: ajoute colonnes admin & name équivalentes à Rails.

# 4 – Migration BD ─────────────────────────────────────────────────
php artisan migrate --quiet
echo "✅ Schéma PostgreSQL créé."
