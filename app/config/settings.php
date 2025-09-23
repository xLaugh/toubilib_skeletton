<?php

use DI\Container;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\adapters\DatabaseConnection;
use toubilib\infra\repositories\PDOPraticienRepository;
use toubilib\infra\repositories\PDORdvRepository;

return [
    // Configuration des bases de données
    PraticienRepositoryInterface::class => function () {
        // Construit la connexion depuis les variables d'environnement (.env / env conteneur)
        $pdo = DatabaseConnection::getConnection('toubiprat');
        return new PDOPraticienRepository($pdo);
    },
    RdvRepositoryInterface::class => function () {
        $pdo = DatabaseConnection::getConnection('toubirdv');
        return new PDORdvRepository($pdo);
    }
];
