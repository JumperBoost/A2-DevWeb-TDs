<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail d'un utilisateur</title>
</head>
<body>
    <?php
    /**
     * @var ModeleUtilisateur $utilisateur
     */
    echo "Utilisateur " . htmlspecialchars($utilisateur->getNom()) . " " . htmlspecialchars($utilisateur->getPrenom()) . " de login " . htmlspecialchars($utilisateur->getLogin());
    ?>
</body>
</html>