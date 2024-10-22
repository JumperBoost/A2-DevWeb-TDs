<form method="GET" action="">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="login_id">Login</label>
            <input class="InputAddOn-field" type="text" placeholder="leblancj" name="login" id="login_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nom_id">Nom</label>
            <input class="InputAddOn-field" type="text" placeholder="Leblanc" name="nom" id="nom_id" required/>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="prenom_id">Prénom</label>
            <input class="InputAddOn-field" type="text" placeholder="Juste" name="prenom" id="prenom_id" required/>
        </p>
        <?php use App\Covoiturage\Lib\ConnexionUtilisateur;
        if(ConnexionUtilisateur::estAdministrateur()) {?>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
                <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id">
            </p>
        <?php }?>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp_id">Mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdpHache" id="mdp_id" required>
        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="mdp2_id">Vérification du mot de passe&#42;</label>
            <input class="InputAddOn-field" type="password" value="" placeholder="" name="mdpHache2" id="mdp2_id" required>
        </p>
        <p class="InputAddOn">
            <input class="InputAddOn-item" type="submit" value="Envoyer" />
        </p>

        <input type='hidden' name='controleur' value='utilisateur'>
        <input type='hidden' name='action' value='creerDepuisFormulaire'>
    </fieldset>
</form>