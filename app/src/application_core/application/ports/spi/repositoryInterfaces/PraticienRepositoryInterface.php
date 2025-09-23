<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;

use toubilib\core\application\ports\api\PraticienDetailDTO;
use toubilib\core\domain\entities\praticien\Praticien;

interface PraticienRepositoryInterface
{
    /**
     * Retourne tous les praticiens avec leurs spécialités
     * 
     * @return Praticien[]
     */
    public function findAll(): array;

    /**
     * Retourne un praticien par son ID
     * 
     * @param string $id
     * @return Praticien|null
     */
    public function findById(string $id): ?Praticien;

    /**
     * Retourne les détails d'un praticien par son ID
     *
     * @param string $id
     * @return PraticienDetailDTO
     */
    public function findDetailById(string $id): PraticienDetailDTO;

}
