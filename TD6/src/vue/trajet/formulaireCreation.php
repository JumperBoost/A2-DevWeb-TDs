<div>
    <form method="GET">
        <fieldset>
            <legend>Création d'un trajet</legend>
            <p>
                <label for="depart_id">Depart</label> :
                <input type="text" placeholder="Montpellier" name="depart" id="depart_id" required/>
            </p>
            <p>
                <label for="arrivee_id">Arrivée</label> :
                <input type="text" placeholder="Sète" name="arrivee" id="arrivee_id" required/>
            </p>
            <p>
                <label for="date_id">Date</label> :
                <input type="date" placeholder="JJ/MM/AAAA" name="date" id="date_id"  required/>
            </p>
            <p>
                <label for="prix_id">Prix</label> :
                <input type="number" placeholder="20" name="prix" id="prix_id"  required/>
            </p>
            <p>
                <label for="conducteurLogin_id">Login du conducteur</label> :
                <select id="conducteurLogin_id" name="conducteurLogin" required>
                    <option value=''>-- Sélectionner un conducteur --</option>
                    <?php
                    /**
                     * @var Utilisateur[] $conducteurs
                     */
                    foreach($conducteurs as $conducteur)
                        echo "<option value='" . htmlspecialchars($conducteur->getLogin()) . "'>" . htmlspecialchars($conducteur->getNom()) . " " . htmlspecialchars($conducteur->getPrenom()) . " (" . htmlspecialchars($conducteur->getLogin()) . ")</option>";
                    ?>
                </select>
            </p>
            <p>
                <label for="nonFumeur_id">Non Fumeur ?</label> :
                <input type="checkbox" placeholder="leblancj" name="nonFumeur" id="nonFumeur_id"/>
            </p>
            <p>
                <input type="submit" value="Envoyer" />
            </p>

            <input type='hidden' name='controleur' value='trajet'>
            <input type='hidden' name='action' value='creerDepuisFormulaire'>
        </fieldset>
    </form>
</div>