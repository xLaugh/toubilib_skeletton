<?php

use DI\Container;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\adapters\DatabaseConnection;
use toubilib\infra\repositories\PDOPraticienRepository;

return [
    // Configuration des bases de données
    PraticienRepositoryInterface::class => function () {
        // Construit la connexion depuis les variables d'environnement (.env / env conteneur)
        $pdo = DatabaseConnection::getConnection('toubiprat');
        return new PDOPraticienRepository($pdo);
    },

    // Service métier
    ServicePraticienInterface::class => function (Container $container) {
        $repository = $container->get(PraticienRepositoryInterface::class);
        return new ServicePraticien($repository);
    },

    // Actions
    ListePraticiensAction::class => function (Container $container) {
        $service = $container->get(ServicePraticienInterface::class);
        return new ListePraticiensAction($service);
    }
];
