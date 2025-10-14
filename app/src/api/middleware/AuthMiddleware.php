<?php

namespace toubilib\api\middleware;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;
use toubilib\core\application\ports\api\ProfileDTO;

class AuthMiddleware
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $authHeader = $request->getHeaderLine('Authorization');
            $token = sscanf($authHeader, "Bearer %s")[0] ;
            $payload = JWT::decode($token, new Key($this->secretKey, 'HS512'));
        } catch (ExpiredException $e) {
        } catch (SignatureInvalidException $e) {
        } catch (BeforeValidException $e) {
        } catch (\UnexpectedValueException $e) { }


        // Créer le profil à partir du token
        $profile = new ProfileDTO(
            id: $payload->sub,
            email: $payload->data->email,
            role: $payload->data->role
        );

        // Ajouter le profil dans la requête pour l'action suivante
        $request = $request->withAttribute('profile', $profile);

        return $handler->handle($request);
    }
}
