<?php
require_once 'Trajet.php';


if(Trajet::isTableauSQLComplet($_POST)) {
    $trajet = Trajet::construireDepuisTableauSQL($_POST);
    if ($trajet->mettreAJour()) {
        echo "<h3>Le trajet id {$trajet->getId()} a été mis à jour avec succès.";
        echo "<p>Redirection vers la liste des trajets dans 3 secondes...</p>";
        $location = "lireTrajets.php";
    } else {
        echo "<h3>Une erreur est survenue lors de la mise à jour du trajet.</h3>";
        echo "<p>Redirection vers la page précédente dans 3 secondes...</p>";
        $location = $_SERVER['HTTP_REFERER'];
    }?>

    <script type="text/javascript">
        (async () => {
            const location = "<?php echo $location ?>";
            await new Promise(r => setTimeout(r, 3000));
            window.location.href = location;
        })();
    </script>
    <?php
} else {
    echo "<h3>Un ou plusieurs paramètres sont manquants. Veuillez vérifier les informations.</h3>";
}