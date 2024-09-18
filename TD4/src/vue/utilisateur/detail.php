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
    echo "Utilisateur {$utilisateur->getNom()} {$utilisateur->getPrenom()} de login {$utilisateur->getLogin()}";
    ?>
</body>
</html>