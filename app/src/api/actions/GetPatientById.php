<?php
namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\core\application\ports\api\ServicePatientInterface;

class GetPatientById
{
    public function __construct(
        private readonly ServicePatientInterface $servicePatient
    )
    {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $id = $args['id'] ?? null;
            $patient = $this->servicePatient->getPatient($id);

            $response->getBody()->write(json_encode([
                'success' => true,
                'data' => $patient->toArray()
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'error' => 'Erreur lors de la récupération du patient',
                'message' => $e->getMessage()
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}