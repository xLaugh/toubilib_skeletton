<?php

namespace toubilib\api\actions;

use mysql_xdevapi\Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use toubilib\core\application\ports\api\CredentialsDTO;
use toubilib\core\application\ports\api\ServiceUserInterface;

//class SigninAction
//{
//    public function __construct(
//        private readonly ServiceUserInterface $serviceUser
//    )
//    {
//    }
//
//    public function __invoke(Request $request, Response $response): Response
//    {
//        try {
//            $data = $request->getBody();
//            $email = $data['email'] ?? '';
//            $password = $data['password'] ?? '';
//
//
//
//        }catch (Exception $e){
//            $response->getBody()->write($e->getMessage());
//            return $response->withStatus(400);
//        }
//
//    }
//}
// PAS FINI


