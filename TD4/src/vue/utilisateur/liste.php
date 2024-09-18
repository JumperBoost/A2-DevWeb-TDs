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
        echo '<p> Utilisateur de login ' . $utilisateur->getLogin() . '. <i><a href="?action=afficherDetail&login=' . $utilisateur->getLogin() . '">Détails</a></i></p>';
    ?>
</body>
</html>