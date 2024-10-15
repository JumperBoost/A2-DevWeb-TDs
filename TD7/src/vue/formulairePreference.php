<?php
/**
 * @var string $preference
 */ ?>
<form method="GET" action="">
    <fieldset>
        <legend>Préférence Controleur</legend>
        <p class="InputAddOn">
            <input class="InputAddOn-item" type="radio" id="utilisateurId" name="controleur_defaut" value="utilisateur" <?= $preference == 'utilisateur' ? "checked" : "" ?>>
            <label class="InputAddOn-field" for="utilisateurId">Utilisateur</label>
        </p>
        <p class="InputAddOn">
            <input class="InputAddOn-item" type="radio" id="trajetId" name="controleur_defaut" value="trajet" <?= $preference == 'trajet' ? "checked" : "" ?>>
            <label class="InputAddOn-field" for="trajetId">Trajet</label>
        </p>
        <p class="InputAddOn">
            <input class="InputAddOn-item" type="submit" value="Envoyer" />
        </p>

        <input type='hidden' name='controleur' value='generique'>
        <input type='hidden' name='action' value='enregistrerPreference'>
    </fieldset>
</form>