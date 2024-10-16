<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Trajet $trajet
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur[] $passagersPotentiel
 */
$nonFumeur = $trajet->isNonFumeur() ? " non fumeur" : " ";
echo "Le trajet$nonFumeur du {$trajet->getDate()->format("d/m/Y")} partira de " . htmlspecialchars($trajet->getDepart()) . " pour aller à " . htmlspecialchars($trajet->getArrivee()) . " (conducteur: " . htmlspecialchars($trajet->getConducteur()->getPrenom()) . " " . htmlspecialchars($trajet->getConducteur()->getNom()) . ").";

echo "<h3>Passagers du trajet</h3><ul>";
foreach($trajet->getPassagers() as $passager)
    echo "<li>Passager " . htmlspecialchars($passager->getNom()) . " " . htmlspecialchars($passager->getPrenom()) . " de login " . htmlspecialchars($passager->getLogin()) . " <i><a href='?controleur=passager&action=desinscrire&id=" . htmlspecialchars($trajet->getId()) . "&login=" . htmlspecialchars($passager->getLogin()) . "'>Désinscrire</a></i></li>";
echo "</ul>";

if(!empty($passagersPotentiel)) {?>
    <form method="GET">
        <label for="passager_id">Ajouter un passager : </label>
        <select id="passager_id" name="login" required>
            <option value="">-- Sélectionner un utilisateur --</option>
            <?php
            foreach($passagersPotentiel as $passager)
                echo "<option value='{$passager->getLogin()}'>" . htmlspecialchars($passager->getNom()) . " " . htmlspecialchars($passager->getPrenom())
                    . " (" . htmlspecialchars($passager->getLogin()) . ")</option>"; ?>
        </select>
        <input type="submit" value="Inscrire">

        <input type="text" name="controleur" value="passager" hidden>
        <input type="text" name="action" value="inscrire" hidden>
        <input type="text" name="id" value=<?= htmlspecialchars($trajet->getId()) ?> hidden>
    </form>
<?php
}