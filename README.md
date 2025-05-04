# 🌿 Plant Shop — E-commerce Botanique (Laravel)

Application complète de vente de plantes en ligne développée avec Laravel 10.

## 🛠️ Stack Technique

### Backend
- **Langage** : PHP 8.2
- **Framework** : Laravel 10
- **Base de données** : PostgreSQL
- **ORM** : Eloquent
- **Authentification** : Laravel Breeze modifié
- **Sécurité** :
  - Authentification par session
  - Middleware `auth`, `admin`
  - Protection CSRF intégrée
- **Validation** : Laravel Validator

### Frontend
- **Templates** : Blade
- **UI/UX** :
  - Bootstrap 5.3 (CDN)
  - CSS personnalisé (orange.css)
- **Panier** :
  - JavaScript vanilla
  - Stockage client via `localStorage`
  - Gestion JS via `resources/js/cart.js`

## 🧩 Fonctionnalités

### Utilisateur
- Inscription / Connexion
- Parcours du catalogue
- Panier dynamique
- Validation de commande
- Historique des commandes
- Modification de profil

### Administrateur
- Accès dédié
- Gestion des plantes (CRUD)
- Gestion des utilisateurs

## 🔐 Sécurité
- Rôles utilisateur (admin / client)
- Middleware `auth` et `admin`
- Validations côté serveur et client

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- PostgreSQL
- Node.js + npm

### Étapes

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances front
npm install && npm run build

# Copier la config d'environnement
cp .env.example .env

# Créer la base PostgreSQL manuellement
# Exemple : CREATE DATABASE plant_shop;

# Modifier .env avec vos accès PostgreSQL
# DB_CONNECTION=pgsql
# DB_DATABASE=plant_shop
# DB_USERNAME=...
# DB_PASSWORD=...

# Appliquer les migrations
php artisan migrate
````

### Lancement

```bash
php artisan serve
```

## 💡 Données de test

```bash
php artisan db:seed
```

## 📁 Structure

* `routes/web.php` : routes publiques / protégées
* `app/Http/Controllers/` : logique métier
* `resources/views/` : vues Blade
* `resources/js/cart.js` : gestion complète du panier
* `resources/views/orders/index.blade.php` : historique ordonné des commandes

## 📦 Fonctionnement du panier

* 100% localStorage côté client
* Ajout / suppression / modification de quantité en JS
* Synchronisé avec la page de validation
* Stock revalidé côté serveur avant confirmation
