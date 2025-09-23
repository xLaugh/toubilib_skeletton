<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubilib\api\actions\DetailPraticienAction;
use toubilib\api\actions\GetRdvById;
use toubilib\api\actions\ListePraticiensAction;

return function( \Slim\App $app):\Slim\App {

    // Route pour lister tous les praticiens
    $app->get('/praticiens', ListePraticiensAction::class);

    //Route pour liser le rdv correspondant à l'id rentré
    $app->get('/rdv/{id}', GetRdvById::class);

    // Route pour obtenir les détails d'un praticien par son ID
    $app->get('/praticiens/{id}', DetailPraticienAction::class);

    return $app;
};