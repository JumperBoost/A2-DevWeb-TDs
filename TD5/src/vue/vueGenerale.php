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
</head>
<body>
<header>
    <nav>
        <!-- Votre menu de navigation ici -->
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
</footer>
</body>
</html>