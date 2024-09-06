<?php
require_once "ConfigurationBaseDeDonnees.php";

class ConnexionBaseDeDonnees {
    private PDO $pdo;

    public function __construct() {
        $config = ConfigurationBaseDeDonnees::class;
        $this->pdo = new PDO("mysql:host={$config::getNomHote()};port={$config::getPort()};dbname={$config::getNomBaseDeDonnees()}", $config::getLogin(), $config::getPassword());
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}