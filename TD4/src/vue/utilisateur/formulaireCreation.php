<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title> Formulaire Utilisateur </title>
</head>

<body>
<form method="GET" action="">
    <fieldset>
        <legend>Mon formulaire :</legend>
        <p>
            <label for="login_id">Login</label> :
            <input type="text" placeholder="leblancj" name="login" id="login_id" required/>
        </p>
        <p>
            <label for="nom_id">Nom</label> :
            <input type="text" placeholder="Leblanc" name="nom" id="nom_id" required/>
        </p>
        <p>
            <label for="prenom_id">Prénom</label> :
            <input type="text" placeholder="Juste" name="prenom" id="prenom_id" required/>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>

        <input type='hidden' name='action' value='creerDepuisFormulaire'>
    </fieldset>
</form>
</body>
</html>