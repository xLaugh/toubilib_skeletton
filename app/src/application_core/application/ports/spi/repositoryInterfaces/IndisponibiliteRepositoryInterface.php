<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;

use toubilib\core\domain\entities\praticien\Indisponibilite;

interface IndisponibiliteRepositoryInterface
{
    public function save(Indisponibilite $indisponibilite): void;

    public function findById(string $id): ?Indisponibilite;

    public function findByPraticienId(string $praticienId): array;

    public function findByPraticienAndPeriod(string $praticienId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): array;

    public function delete(string $id): void;
}

