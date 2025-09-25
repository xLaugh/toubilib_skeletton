<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubilib\api\actions\DetailPraticienAction;
use toubilib\api\actions\GetPatientById;
use toubilib\api\actions\GetRdvById;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\api\actions\ListerCreneauxOccupesAction;
use toubilib\api\actions\AgendaPraticienAction;
use toubilib\api\actions\AnnulerRDVAction;

return function( \Slim\App $app):\Slim\App {

    // Route pour lister tous les praticiens
    $app->get('/praticiens', ListePraticiensAction::class);

    //Route pour liser le rdv correspondant à l'id rentré
    $app->get('/rdv/{id}', GetRdvById::class);

    // Route pour obtenir les détails d'un praticien par son ID
    $app->get('/praticiens/{id}', DetailPraticienAction::class);

    // Route pour lister les créneaux occupés d'un praticien sur une période
    $app->get('/praticiens/{id}/rdv/occupes', ListerCreneauxOccupesAction::class);

    // Agenda praticien
    $app->get('/praticiens/{id}/agenda', AgendaPraticienAction::class);

    // Annulation de rendez-vous
    $app->post('/rdv/{id}/annuler', AnnulerRDVAction::class);

    // Route pour obtenir un patient selon un id
    $app->get('/patients/{id}', GetPatientById::class);

    return $app;
};