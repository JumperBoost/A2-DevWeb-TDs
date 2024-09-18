<!DOCTYPE html>
<html>
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
        echo '<p> Utilisateur de login ' . $utilisateur->getLogin() . '.</p>';
    ?>
</body>
</html>