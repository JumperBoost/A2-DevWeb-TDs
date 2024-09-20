<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <?php
    /**
     * @var ModeleUtilisateur[] $utilisateurs
     */
    foreach ($utilisateurs as $utilisateur)
        echo '<p> Utilisateur de login ' . htmlspecialchars($utilisateur->getLogin()) . '. <i><a href="?action=afficherDetail&login=' . htmlspecialchars($utilisateur->getLogin()) . '">Détails</a></i></p>';

    echo "<i><a href='?action=afficherFormulaireCreation'>Créer un utilisateur</a></i>";
    ?>
</body>
</html>