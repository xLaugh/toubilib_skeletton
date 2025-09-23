<?php

use DI\Container;
use toubilib\api\actions\DetailPraticienAction;
use toubilib\api\actions\GetRdvById;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\api\actions\ListerCreneauxOccupesAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRdvInterface;

return [
    ListePraticiensAction::class => function (Container $container) {
        $service = $container->get(ServicePraticienInterface::class);
        return new ListePraticiensAction($service);
    },
    GetRdvById::class => function (Container $container){
        $service = $container->get(ServiceRdvInterface::class);
        return new GetRdvById($service);
    },
    DetailPraticienAction::class => function (Container $container){
        $service = $container->get(ServicePraticienInterface::class);
        return new DetailPraticienAction($service);
    },
    ListerCreneauxOccupesAction::class => function (Container $container){
        $service = $container->get(ServiceRdvInterface::class);
        return new ListerCreneauxOccupesAction($service);
    }
];