<?php
/**
 * @var Trajet $trajet
 */
?>

<div>
    <form method="GET">
        <fieldset>
            <legend>Mise à jour d'un trajet</legend>
            <p>
                <label for="id_id">Identifiant</label> :
                <input type="text" name="id" id="id_id" value="<?= $trajet->getId() ?>" readonly required/>
            </p>
            <p>
                <label for="depart_id">Depart</label> :
                <input type="text" placeholder="Montpellier" name="depart" id="depart_id" value="<?= htmlspecialchars($trajet->getDepart()) ?>" required/>
            </p>
            <p>
                <label for="arrivee_id">Arrivée</label> :
                <input type="text" placeholder="Sète" name="arrivee" id="arrivee_id" value="<?= htmlspecialchars($trajet->getArrivee()) ?>" required/>
            </p>
            <p>
                <label for="date_id">Date</label> :
                <input type="date" placeholder="JJ/MM/AAAA" name="date" id="date_id" value="<?= $trajet->getDate()->format("Y-m-d") ?>" required/>
            </p>
            <p>
                <label for="prix_id">Prix</label> :
                <input type="number" placeholder="20" name="prix" id="prix_id" value="<?= $trajet->getPrix() ?>" required/>
            </p>
            <p>
                <label for="conducteurLogin_id">Login du conducteur</label> :
                <input type="text" placeholder="leblancj" name="conducteurLogin" id="conducteurLogin_id" value="<?= htmlspecialchars($trajet->getConducteur()->getLogin()) ?>" required/>
            </p>
            <p>
                <label for="nonFumeur_id">Non Fumeur ?</label> :
                <input type="checkbox" placeholder="leblancj" name="nonFumeur" id="nonFumeur_id" <?= $trajet->isNonFumeur() ? "checked" : "" ?>/>
            </p>
            <p>
                <input type="submit" value="Envoyer" />
            </p>

            <input type='hidden' name='controleur' value='trajet'>
            <input type='hidden' name='action' value='mettreAJour'>
        </fieldset>
    </form>
</div>