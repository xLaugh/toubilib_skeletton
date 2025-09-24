<?php

use DI\Container;
use toubilib\api\actions\DetailPraticienAction;
use toubilib\api\actions\GetRdvById;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\api\actions\ListerCreneauxOccupesAction;
use toubilib\api\actions\AgendaPraticienAction;
use toubilib\api\actions\AnnulerRDVAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRdvInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\core\application\usecases\ServiceRdv;

return [

    // Service métier pour les praticiens
    ServicePraticienInterface::class => function ($c) {
        $repo = $c->get(PraticienRepositoryInterface::class);
        return new ServicePraticien($repo);
    },

    // Service métier pour les rendez-vous
    ServiceRdvInterface::class => function ($c) {
        $repo = $c->get(RdvRepositoryInterface::class);
        return new ServiceRdv($repo);
    },

    // Liste des praticiens
    ListePraticiensAction::class => function ($c) {
        return new ListePraticiensAction(
            $c->get(ServicePraticienInterface::class)
        );
    },

    // Détail d’un praticien
    DetailPraticienAction::class => function ($c) {
        return new DetailPraticienAction(
            $c->get(ServicePraticienInterface::class)
        );
    },

    // Rendez-vous par ID
    GetRdvById::class => function ($c) {
        return new GetRdvById(
            $c->get(ServiceRdvInterface::class)
        );
    },

    // Créneaux occupés
    ListerCreneauxOccupesAction::class => function ($c) {
        return new ListerCreneauxOccupesAction(
            $c->get(ServiceRdvInterface::class)
        );
    },
    // Agenda praticien
    AgendaPraticienAction::class => function ($c) {
        return new AgendaPraticienAction(
            $c->get(ServiceRdvInterface::class)
        );
    },
    // Annuler un RDV
    AnnulerRDVAction::class => function ($c) {
        return new AnnulerRDVAction(
            $c->get(ServiceRdvInterface::class)
        );
    }
];
