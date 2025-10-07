<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\core\application\ports\api\CredentialsDTO;
use toubilib\core\application\ports\api\ServiceUserInterface;

class SigninAction
{
    public function __construct(
        private readonly ServiceUserInterface $serviceUser
    ) {}

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody() ?? [];
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if ($email === '' || $password === '') {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'error' => 'parametres_invalides'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $profile = $this->serviceUser->byCredentials(new CredentialsDTO($email, $password));
            if ($profile === null) {
                $response->getBody()->write(json_encode([
                    'success' => false,
                    'error' => 'credentials_invalides'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            $accessToken = base64_encode(random_bytes(32));
            $refreshToken = base64_encode(random_bytes(48));

            $response->getBody()->write(json_encode([
                'success' => true,
                'profile' => [
                    'id' => $profile->id,
                    'email' => $profile->email,
                    'role' => $profile->role,
                ],
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                'success' => false,
                'error' => 'erreur_interne'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}


