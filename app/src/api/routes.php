<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use toubilib\api\actions\CreerRendezVousAction;
use toubilib\api\actions\DetailPraticienAction;
use toubilib\api\actions\GetPatientById;
use toubilib\api\actions\GetRdvById;
use toubilib\api\actions\ListePraticiensAction;
use toubilib\api\actions\ListerCreneauxOccupesAction;
use toubilib\api\actions\AgendaPraticienAction;
use toubilib\api\actions\AnnulerRDVAction;
use toubilib\api\middleware\ValidateRDVMiddleware;
use toubilib\api\actions\SigninAction;

return function( \Slim\App $app):\Slim\App {

    // Route pour lister tous les praticiens
    $app->get('/praticiens', ListePraticiensAction::class)->setName("praticiens.all");

    //Route pour liser le rdv correspondant à l'id rentré
    $app->get('/rdvs/{id}', GetRdvById::class)->setName("rdvs.id");

    // Route pour obtenir les détails d'un praticien par son ID
    $app->get('/praticiens/{id}', DetailPraticienAction::class)->setName("praticien.id");

    // Route pour lister les créneaux occupés d'un praticien sur une période
    $app->get('/praticiens/{id}/rdvs', ListerCreneauxOccupesAction::class)->setName("praticien.crenaux");

    // Agenda praticien
    $app->get('/praticiens/{id}/agenda', AgendaPraticienAction::class)->setName("praticien.aganda");

    // Annulation de rendez-vous
    $app->post('/rdvs/{id}/annuler', AnnulerRDVAction::class)->setName("rdvs");

    // Route pour obtenir un patient selon un id
    $app->get('/patients/{id}', GetPatientById::class)->setName("patients.id");

    //Route pour ajouter un Rendez-Vous
    $app->post('/rdvs', CreerRendezVousAction::class)->add(ValidateRDVMiddleware::class)->setName("rdv.ajout");

    // Auth
    $app->post('/auth/signin', SigninAction::class)->setName('auth.signin');

    return $app;
};