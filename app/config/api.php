<?php

use DI\Container;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;

return [
    ListePraticiensAction::class => function (Container $container) {
        $service = $container->get(ServicePraticienInterface::class);
        return new ListePraticiensAction($service);
    }
];