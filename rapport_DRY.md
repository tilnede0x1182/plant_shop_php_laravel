# RAPPORT D'ANALYSE DES DUPLICATIONS DE CODE (Principe DRY)

## Introduction
Projet Laravel (blade + routes web + admin).

---

## Violations DRY

### 1. Deux contrôleurs Plantes pour la même logique - 🔴 Critique
`App\Http\Controllers\PlantsController` (public) et `App\Http\Controllers\Admin\PlantsController` réécrivent tous les accès `Plant::orderBy()->get()`, validations et vues. Une modification métier (ex. nouveau champ `category`) devra être portée dans deux classes. **Action** : extraire un `PlantService` (liste, CRUD) et l’injecter dans les contrôleurs, ou utiliser des Form Requests + resources partagées afin de centraliser la logique.

### 2. Règles de validation dupliquées - 🟠 Haute
Dans `Admin\PlantsController`, les méthodes `store` et `update` copient exactement le même tableau `$request->validate([...])`. Même duplication côté utilisateurs (admin vs profil). **Action** : créer des Form Requests (`StorePlantRequest`, `UpdatePlantRequest`) et les réutiliser, ce qui garantit l’unicité des règles.

### 3. Mise à jour d’utilisateur répétée (profil vs admin) - 🟠 Haute
`ProfileController@update` et `Admin\UsersController@update` manipulent tous deux les mêmes champs (`name`, `email`, statut admin) et gèrent l’invalidation de l’email. Sans service commun, chaque modification (nouvelle contrainte, normalisation) doit être synchronisée à deux endroits. **Action** : implémenter un `UserService::updateProfile($user, $data, $allowAdminFlag)` appelé par les deux contrôleurs.

---

## Impact estimé

| Refactoring proposé                         | Lignes supprimées | Complexité |
|---------------------------------------------|-------------------|------------|
| Service/Requests partagés pour les plantes  | ~120              | Faible     |
| Form Requests pour mutualiser les règles    | ~40               | Faible     |
| Service unique de mise à jour utilisateur   | ~60               | Faible     |

---

## Conclusion
La séparation public/admin a été faite en copiant les contrôleurs et validations, ce qui va rapidement diverger. Centraliser la logique dans des services/Form Requests garantit le respect du principe DRY imposé au projet.***
