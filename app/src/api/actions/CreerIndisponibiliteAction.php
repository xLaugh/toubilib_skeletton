<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\ports\api\ServiceIndisponibiliteInterface;

class CreerIndisponibiliteAction
{
    public function __construct(
        private ServiceIndisponibiliteInterface $serviceIndisponibilite
    ) {}

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $dto = $request->getAttribute('inputIndisponibiliteDTO');
        $dto->praticien_id = $args['id'] ?? $dto->praticien_id;

        try {
            $indisponibilite = $this->serviceIndisponibilite->creerIndisponibilite($dto);

            $response->getBody()->write(json_encode([
                'success' => true,
                'data' => $indisponibilite->toArray()
            ], JSON_PRETTY_PRINT));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);

        } catch (\DomainException $e) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ], JSON_PRETTY_PRINT));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'error' => 'Erreur interne : ' . $e->getMessage()
            ], JSON_PRETTY_PRINT));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}

