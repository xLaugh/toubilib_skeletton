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

    /**
     * Retourne les détails d'un praticien par son ID
     *
     * @param string $id
     * @return PraticienDetailDTO|null
     */
    public function getPraticienDetail(string $id): ?PraticienDetailDTO;

}
