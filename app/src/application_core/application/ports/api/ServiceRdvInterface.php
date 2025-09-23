<?php
namespace toubilib\core\application\ports\api;

interface ServiceRdvInterface
{
    public function listerRdv(): array;
    public function chercherParId(string $id): ?RdvDTO;
}
