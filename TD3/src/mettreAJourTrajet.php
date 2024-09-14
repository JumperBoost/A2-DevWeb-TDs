<html lang="fr">
<head>
    <title>Formulaire de MAJ de trajet</title>
    <meta charset="utf-8">
</head>
<body>
    <?php
    require_once 'Trajet.php';

    $trajetId = $_GET['trajet_id'] ?? null;

    if(!is_null($trajetId)) {
        $trajet = Trajet::recupererTrajetParId($trajetId);
        if(!is_null($trajet)) {
            echo "<h3>Modifier ci-dessous les informations liées au trajet id $trajetId</h3>"
            ?>
            <form method="post" action="traiterMettreAJourTrajet.php">
                <fieldset>
                    <legend>Modification trajet id <?php echo $trajetId ?></legend>
                    <p>
                        <label for="prix_id">Prix: </label>
                        <input type="number" name="prix" id="prix_id" value="<?php echo $trajet->getPrix() ?>" />
                    </p>
                    <p>
                        <label for="date_id">Date: </label>
                        <input type="date" name="date" id="date_id" value="<?php echo $trajet->getDate()->format('Y-m-d') ?>" />
                    </p>
                    <p>
                        <label for="depart_id">Départ: </label>
                        <input type="text" name="depart" id="depart_id" value="<?php echo $trajet->getDepart() ?>" />
                    </p>
                    <p>
                        <label for="arrivee_id">Arrivée: </label>
                        <input type="text" name="arrivee" id="arrivee_id" value="<?php echo $trajet->getArrivee() ?>" />
                    </p>
                    <p>
                        <label for="conducteur_id">Conducteur: </label>
                        <select name="conducteurLogin" id="conducteur_id">
                            <?php
                            $conducteur = $trajet->getConducteur();
                            echo "<option value='{$conducteur->getLogin()}' selected>{$conducteur->getLogin()} ({$conducteur->getNom()} {$conducteur->getPrenom()})</option>";

                            $utilisateurs = Utilisateur::recupererUtilisateurs();
                            foreach ($utilisateurs as $utilisateur) {
                                if($utilisateur != $conducteur) {
                                    echo "<option value='{$utilisateur->getLogin()}'>{$utilisateur->getLogin()} ({$utilisateur->getNom()} {$utilisateur->getPrenom()})</option>";
                                }
                            }
                            ?>
                        </select>
                    </p>
                    <p>
                        <label for="nonFumeur_id" >Non fumeur: </label>
                        <input type="checkbox" name="nonFumeur" id="nonFumeur_id" <?php if($trajet->isNonFumeur()) echo "checked" ?>>
                    </p>

                    <input type="hidden" name="id" value="<?php echo $trajetId ?>">
                    <input type="submit" value="Enregistrer" />
                </fieldset>
            </form>
            <?php
        } else header("Location: {$_SERVER['PHP_SELF']}");
    } else {
        ?>
        <h2>Veuillez spécifier le trajet à modifier ci-dessous</h2>
        <form method="get">
            <fieldset>
                <legend>Modification d'un trajet</legend>
                <p>
                    <select id="trajet_id" name="trajet_id">
                        <option value="">-- Sélectionner un trajet --</option>
                        <?php
                        $trajets = Trajet::recupererTrajets();
                        foreach ($trajets as $trajet) {
                            echo "<option value='{$trajet->getId()}'>{$trajet->getId()} ({$trajet->getDate()->format('Y-m-d')}, {$trajet->getDepart()} <=> {$trajet->getArrivee()})</option>";
                        }
                        ?>
                    </select>
                </p>

                <input type="submit" value="Continuer" />
            </fieldset>
        </form>
    <?php }
    ?>
</body>
</html>
