<?php require_once 'Utilisateur.php' ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title> Test Utilisateur </title>
    <meta charset="utf-8" />
</head>

<body>
    <?php
        $utilisateur1 = new Utilisateur("rigauxh", "Rigaux", "Héloïse");
        echo $utilisateur1;
    ?>
</body>
</html>
