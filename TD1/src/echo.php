<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title> Mon premier php </title>
    </head>
   
    <body>
        Voici le résultat du script PHP : 
        <?php
        // Ceci est un commentaire PHP sur une ligne
        /* Ceci est le 2ème type de commentaire PHP
        sur plusieurs lignes */

        // On met la chaine de caractères "hello" dans la variable 'texte'
        // Les noms de variable commencent par $ en PHP
        $texte = "hello world !<br>";

        // On écrit le contenu de la variable 'texte' dans la page Web
        echo $texte;

        $prenom = "Marc";

        echo "Bonjour\n " . $prenom . "<br>";
        echo "Bonjour\n $prenom <br>";
        echo 'Bonjour\n $prenom<br>';

        echo "$prenom<br>";
        echo "$prenom<br>";

        $utilisateur = [
            'nom' => "Leblanc",
            'prenom' => "Juste",
            'login' => "leblancj"
        ];
        var_dump($utilisateur);

        echo "<p>Utilisateur $utilisateur[nom] $utilisateur[prenom] de login $utilisateur[login]</p>";

        $utilisateurs = [
            0 => ['nom' => "Renaud", 'prenom' => "Julien", 'login' => "renaudj"],
            1 => $utilisateur
        ];
        var_dump($utilisateurs);

        echo "<h1>Liste des utilisateurs</h1>";
        $liste = "<ul>";
        foreach ($utilisateurs as $key => $value) {
            $liste .= "<li>Utilisateur $value[nom] $value[prenom] de login $value[login]</p>";
        }
        if(empty($utilisateurs))
            echo "<p>Il n'y a aucun utilisateur.</p>";
        else
            echo "$liste</ul>";
        ?>
    </body>
</html> 