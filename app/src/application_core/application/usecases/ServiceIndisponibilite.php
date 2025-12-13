<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\IndisponibiliteDTO;
use toubilib\core\application\ports\api\InputIndisponibiliteDTO;
use toubilib\core\application\ports\api\ServiceIndisponibiliteInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\IndisponibiliteRepositoryInterface;
use toubilib\core\domain\entities\praticien\Indisponibilite;
use Ramsey\Uuid\Uuid;

class ServiceIndisponibilite implements ServiceIndisponibiliteInterface
{
    private IndisponibiliteRepositoryInterface $repository;

    public function __construct(IndisponibiliteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function creerIndisponibilite(InputIndisponibiliteDTO $dto): IndisponibiliteDTO
    {
        $debut = new \DateTimeImmutable($dto->date_debut);
        $fin = new \DateTimeImmutable($dto->date_fin);

        if ($debut >= $fin) {
            throw new \DomainException("La date de début doit être antérieure à la date de fin");
        }

        $indisponibilites = $this->repository->findByPraticienAndPeriod($dto->praticien_id, $debut, $fin);
        if (!empty($indisponibilites)) {
            throw new \DomainException("Une indisponibilité existe déjà sur cette période");
        }

        $id = Uuid::uuid4();
        $indisponibilite = new Indisponibilite(
            id: $id,
            praticienId: Uuid::fromString($dto->praticien_id),
            dateDebut: $debut,
            dateFin: $fin,
            raison: $dto->raison,
            dateCreation: new \DateTimeImmutable()
        );

        $this->repository->save($indisponibilite);

        return new IndisponibiliteDTO(
            id: $indisponibilite->getId()->toString(),
            praticien_id: $indisponibilite->getPraticienId()->toString(),
            date_debut: $indisponibilite->getDateDebut()->format('Y-m-d H:i:s'),
            date_fin: $indisponibilite->getDateFin()->format('Y-m-d H:i:s'),
            raison: $indisponibilite->getRaison(),
            date_creation: $indisponibilite->getDateCreation()?->format('Y-m-d H:i:s')
        );
    }

    public function listerIndisponibilites(string $praticienId): array
    {
        $indisponibilites = $this->repository->findByPraticienId($praticienId);

        return array_map(function ($indisponibilite) {
            return new IndisponibiliteDTO(
                id: $indisponibilite->getId()->toString(),
                praticien_id: $indisponibilite->getPraticienId()->toString(),
                date_debut: $indisponibilite->getDateDebut()->format('Y-m-d H:i:s'),
                date_fin: $indisponibilite->getDateFin()->format('Y-m-d H:i:s'),
                raison: $indisponibilite->getRaison(),
                date_creation: $indisponibilite->getDateCreation()?->format('Y-m-d H:i:s')
            );
        }, $indisponibilites);
    }

    public function supprimerIndisponibilite(string $id): void
    {
        $indisponibilite = $this->repository->findById($id);
        if ($indisponibilite === null) {
            throw new \DomainException("Indisponibilité introuvable");
        }

        $this->repository->delete($id);
    }

    public function verifierIndisponibilite(string $praticienId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): bool
    {
        $indisponibilites = $this->repository->findByPraticienAndPeriod($praticienId, $debut, $fin);
        return !empty($indisponibilites);
    }
}

