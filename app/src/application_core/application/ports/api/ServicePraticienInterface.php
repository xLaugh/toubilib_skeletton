<?php

namespace toubilib\core\application\ports\api;

interface ServicePraticienInterface
{
    /**
     * Retourne la liste complète des praticiens avec leurs informations de base
     * 
     * @return PraticienDTO[]
     */
    public function listerPraticiens(): array;
    public function getPraticienDetail(string $id): ?PraticienDetailDTO;

}
