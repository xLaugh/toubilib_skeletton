<?php

namespace toubilib\api\middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Exception\HttpBadRequestException;
use toubilib\core\application\ports\api\InputIndisponibiliteDTO;

class ValidateIndisponibiliteMiddleware
{
    public function __invoke(ServerRequestInterface $rq, RequestHandlerInterface $next): ResponseInterface
    {
        $data = $rq->getParsedBody() ?? null;

        try {
            v::key('date_debut', v::dateTime('Y-m-d H:i:s'))
                ->key('date_fin', v::dateTime('Y-m-d H:i:s'))
                ->assert($data);
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($rq, "Invalid data: " . $e->getFullMessage(), $e);
        }

        $data['raison'] = isset($data['raison']) ? filter_var($data['raison'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

        $dto = new InputIndisponibiliteDTO(
            praticien_id: '',
            date_debut: $data['date_debut'],
            date_fin: $data['date_fin'],
            raison: $data['raison']
        );

        $rq = $rq->withAttribute('inputIndisponibiliteDTO', $dto);

        return $next->handle($rq);
    }
}

