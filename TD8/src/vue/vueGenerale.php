<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php
        /**
         * @var string $titre
         */
        echo $titre; ?>
    </title>
    <link rel="stylesheet" href="../ressources/css/navstyle.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li>
                <a href="?action=afficherListe&controleur=utilisateur">Gestion des utilisateurs</a>
            </li>
            <li>
                <a href="?action=afficherListe&controleur=trajet">Gestion des trajets</a>
            </li>
            <li>
                <a href="?action=afficherFormulairePreference&controleur=generique"><img src="../ressources/img/heart.png" /></a>
            </li>
            <?php /** @var bool $_estConnecte */
            if(!$_estConnecte) {?>
                <li>
                    <a href="?action=afficherFormulaireCreation&controleur=utilisateur"><img src="../ressources/img/add-user.png" /></a>
                </li>
                <li>
                    <a href="?action=afficherFormulaireConnexion&controleur=utilisateur"><img src="../ressources/img/enter.png" /></a>
                </li>
            <?php } else {?>
                <li>
                    <a href="?action=afficherDetail&controleur=utilisateur"><img src="../ressources/img/user.png" /></a>
                </li>
                <li>
                    <a href="?action=deconnecter&controleur=utilisateur"><img src="../ressources/img/logout.png" /></a>
                </li>
            <?php }?>
        </ul>
    </nav>
</header>
<main>
    <?php
    /**
     * @var string $cheminCorpsVue
     */
    require __DIR__ . "/{$cheminCorpsVue}";
    ?>
</main>
<footer>
    <p>
        Site de covoiturage à trois roues.
    </p>
</footer>
</body>
</html>