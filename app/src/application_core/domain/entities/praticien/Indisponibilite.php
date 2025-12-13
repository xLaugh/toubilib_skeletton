<?php

namespace toubilib\core\domain\entities\praticien;

use Ramsey\Uuid\UuidInterface;

class Indisponibilite
{
    public function __construct(
        private UuidInterface $id,
        private UuidInterface $praticienId,
        private \DateTimeImmutable $dateDebut,
        private \DateTimeImmutable $dateFin,
        private ?string $raison = null,
        private ?\DateTimeImmutable $dateCreation = null
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getPraticienId(): UuidInterface
    {
        return $this->praticienId;
    }

    public function getDateDebut(): \DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function getDateFin(): \DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function chevauche(\DateTimeImmutable $debut, \DateTimeImmutable $fin): bool
    {
        return $debut < $this->dateFin && $fin > $this->dateDebut;
    }
}

