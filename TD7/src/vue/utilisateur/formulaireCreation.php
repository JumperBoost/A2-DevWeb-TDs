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
        <p class="InputAddOn">
            <input class="InputAddOn-item" type="submit" value="Envoyer" />
        </p>

        <input type='hidden' name='action' value='creerDepuisFormulaire'>
    </fieldset>
</form>