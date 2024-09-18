# Réponses aux questions du TD4 - Architecture MVC simple

## Exercice 1
✅

## Exercice 2
✅

## Exercice 3
1. ✅
2. ✅
3. `ControleurUtilisateur.php` est similaire à l'ancien fichier `lireUtilisateur.php` puisque ils exécutent tous les deux dans l'ordre suivant :
    - Chargement du modèle `Utilisateur` si nécessaire
    - Récupération des données depuis le modèle
    - Affichage des données via la vue

   La seule différence est que la vue est mieux structurée et comporte du HTML.

## Exercice 4
1. ✅
2. ✅
3. `routeur.php` exécute `ControleurUtilisateur.php::afficherListe()`, puis est exécuté dans l'ordre cité dans l'exercice précédent.

## Exercice 5
1. ✅
2. ✅
3. Le code n'est plus vraiment similaire à l'ancien fichier `lireUtilisateur.php` puisqu'on peut exécuter n'importe quelle méthode statique du contrôleur en le précisant dans la requête.

## Exercice 6
✅
