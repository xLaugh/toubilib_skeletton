<?php
namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\core\application\ports\api\ServicePraticienInterface;

class DetailPraticienAction
{
    public function __construct(
        private ServicePraticienInterface $servicePraticien
    ) {}

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'] ?? null;

        if (!$id) {
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json')
                ->withBody(\Slim\Psr7\Factory\StreamFactory::createStream(
                    json_encode(['success' => false, 'error' => 'Missing praticien ID'])
                ));
        }

        $detail = $this->servicePraticien->getPraticienDetail($id);

        if (!$detail) {
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json')
                ->withBody(\Slim\Psr7\Factory\StreamFactory::createStream(
                    json_encode(['success' => false, 'error' => 'Praticien not found'])
                ));
        }

        $response->getBody()->write(json_encode([
            'success' => true,
            'data' => $detail->toArray()
        ]));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
