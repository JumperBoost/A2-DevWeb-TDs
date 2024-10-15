<?php
/**
 * @var \App\Covoiturage\Modele\DataObject\Utilisateur $utilisateur
 */
echo "Utilisateur " . htmlspecialchars($utilisateur->getNom()) . " " . htmlspecialchars($utilisateur->getPrenom()) . " de login " . htmlspecialchars($utilisateur->getLogin());
