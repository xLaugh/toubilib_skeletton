<?php

namespace toubilib\core\application\ports\api;

interface ServiceIndisponibiliteInterface
{
    public function creerIndisponibilite(InputIndisponibiliteDTO $dto): IndisponibiliteDTO;

    public function listerIndisponibilites(string $praticienId): array;

    public function supprimerIndisponibilite(string $id): void;

    public function verifierIndisponibilite(string $praticienId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): bool;
}

