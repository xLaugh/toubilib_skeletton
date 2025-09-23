<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;


use toubilib\core\domain\entities\Rdv;

interface RdvRepositoryInterface {
    /**
     * Retourne tous les rendez-vous
     *
     * @return Rdv[]
     */
    public function findAll(): array;

    /**
     * Retourne un rendez-vous par son ID
     *
     * @param string $id
     * @return Rdv|null
     */
    public function findById(string $id): ?Rdv;
}
