<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur $utilisateur
 */
?>

<form method="GET" action="">
    <fieldset>
        <legend>Formulaire de mise à jour :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login</label>
            <input class="InputAddOn-field" type="text" name="login" id="login_id" value="<?= htmlspecialchars($utilisateur->getLogin()) ?>" readonly required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="Leblanc" name="nom" id="nom_id" value="<?= htmlspecialchars($utilisateur->getNom()) ?>" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prénom</label>
            <input class="InputAddOn-field" type="text" placeholder="Juste" name="prenom" id="prenom_id" value="<?= htmlspecialchars($utilisateur->getPrenom()) ?>" required/>
        </p>
        <p class="InputAddOn">
            <input class="InputAddOn-item" type="submit" value="Envoyer" />
        </p>

        <input type='hidden' name='action' value='mettreAJour'>
    </fieldset>
</form>