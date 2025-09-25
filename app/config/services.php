<?php

use DI\Container;
use toubilib\core\application\ports\api\ServicePatientInterface;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRdvInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PatientRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\usecases\ServicePatient;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;
use toubilib\core\application\usecases\ServiceRdv;

return [
    ServicePraticienInterface::class => function (Container $container) {
        $repository = $container->get(PraticienRepositoryInterface::class);
        return new ServicePraticien($repository);
    },
    ServicePatientInterface::class => function(Container $container){
        $repository = $container->get(PatientRepositoryInterface::class);
        return new ServicePatient($repository);
    },
    ServiceRdvInterface::class => function (Container $container){
        $repository = $container->get(RdvRepositoryInterface::class);
        $servicePatient = $container->get(ServicePatientInterface::class);
        $servicePatricien = $container->get(ServicePraticienInterface::class);
        return new ServiceRdv($repository, $servicePatient, $servicePatricien);
    },
];