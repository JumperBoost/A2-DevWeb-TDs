<?php
/**
 * @var ModeleUtilisateur $utilisateur
 */
echo "Utilisateur " . htmlspecialchars($utilisateur->getNom()) . " " . htmlspecialchars($utilisateur->getPrenom()) . " de login " . htmlspecialchars($utilisateur->getLogin());
