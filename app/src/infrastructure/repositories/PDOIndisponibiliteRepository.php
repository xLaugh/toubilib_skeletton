<?php

namespace toubilib\infra\repositories;

use PDO;
use toubilib\core\application\ports\spi\repositoryInterfaces\IndisponibiliteRepositoryInterface;
use toubilib\core\domain\entities\praticien\Indisponibilite;
use Ramsey\Uuid\Uuid;

class PDOIndisponibiliteRepository implements IndisponibiliteRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Indisponibilite $indisponibilite): void
    {
        $sql = "INSERT INTO indisponibilite (id, praticien_id, date_debut, date_fin, raison, date_creation)
                VALUES (:id, :praticien_id, :date_debut, :date_fin, :raison, :date_creation)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $indisponibilite->getId()->toString());
        $stmt->bindValue(':praticien_id', $indisponibilite->getPraticienId()->toString());
        $stmt->bindValue(':date_debut', $indisponibilite->getDateDebut()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':date_fin', $indisponibilite->getDateFin()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':raison', $indisponibilite->getRaison());
        $dateCreation = $indisponibilite->getDateCreation() ?? new \DateTimeImmutable();
        $stmt->bindValue(':date_creation', $dateCreation->format('Y-m-d H:i:s'));
        $stmt->execute();
    }

    public function findById(string $id): ?Indisponibilite
    {
        $sql = "SELECT * FROM indisponibilite WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return $this->hydrate($row);
    }

    public function findByPraticienId(string $praticienId): array
    {
        $sql = "SELECT * FROM indisponibilite WHERE praticien_id = :praticien_id ORDER BY date_debut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':praticien_id', $praticienId);
        $stmt->execute();

        $indisponibilites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $indisponibilites[] = $this->hydrate($row);
        }

        return $indisponibilites;
    }

    public function findByPraticienAndPeriod(string $praticienId, \DateTimeImmutable $debut, \DateTimeImmutable $fin): array
    {
        $sql = "SELECT * FROM indisponibilite 
                WHERE praticien_id = :praticien_id 
                  AND date_debut < :fin 
                  AND date_fin > :debut
                ORDER BY date_debut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':praticien_id', $praticienId);
        $stmt->bindValue(':debut', $debut->format('Y-m-d H:i:s'));
        $stmt->bindValue(':fin', $fin->format('Y-m-d H:i:s'));
        $stmt->execute();

        $indisponibilites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $indisponibilites[] = $this->hydrate($row);
        }

        return $indisponibilites;
    }

    public function delete(string $id): void
    {
        $sql = "DELETE FROM indisponibilite WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    private function hydrate(array $row): Indisponibilite
    {
        return new Indisponibilite(
            id: Uuid::fromString($row['id']),
            praticienId: Uuid::fromString($row['praticien_id']),
            dateDebut: new \DateTimeImmutable($row['date_debut']),
            dateFin: new \DateTimeImmutable($row['date_fin']),
            raison: $row['raison'],
            dateCreation: $row['date_creation'] ? new \DateTimeImmutable($row['date_creation']) : null
        );
    }
}

