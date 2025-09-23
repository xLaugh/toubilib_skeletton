<?php

namespace toubilib\infra\repositories;

use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;
use toubilib\core\domain\entities\Rdv;

class PDORdvRepository implements RdvRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM rdv ORDER BY date_heure_debut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $rdvs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rdvs[] = new Rdv(
                id: $row['id'],
                praticien_id: $row['praticien_id'],
                patient_id: $row['patient_id'],
                date_heure_debut: $row['date_heure_debut'],
                status: (int) $row['status'],
                duree: (int) $row['duree'],
                date_heure_fin: $row['date_heure_fin'],
                date_creation: $row['date_creation'],
                motif_visite: $row['motif_visite']
            );
        }

        return $rdvs;
    }

    public function findById(string $id): ?Rdv
    {
        $sql = "SELECT * FROM rdv WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return new Rdv(
            id: $row['id'],
            praticien_id: $row['praticien_id'],
            patient_id: $row['patient_id'],
            date_heure_debut: $row['date_heure_debut'],
            status: (int) $row['status'],
            duree: (int) $row['duree'],
            date_heure_fin: $row['date_heure_fin'],
            date_creation: $row['date_creation'],
            motif_visite: $row['motif_visite']
        );
    }

    public function findByPraticienAndPeriod(string $praticienId, string $dateDebut, string $dateFin): array
    {
        $sql = "SELECT 
                    id,
                    praticien_id,
                    patient_id,
                    date_heure_debut,
                    status,
                    duree,
                    COALESCE(date_heure_fin, date_heure_debut + (duree || ' minutes')::interval) AS date_heure_fin,
                    date_creation,
                    motif_visite
                FROM rdv
                WHERE praticien_id = :pid
                  AND date_heure_debut < :fin
                  AND COALESCE(date_heure_fin, date_heure_debut + (duree || ' minutes')::interval) > :debut
                ORDER BY date_heure_debut";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':pid', $praticienId);
        $stmt->bindParam(':debut', $dateDebut);
        $stmt->bindParam(':fin', $dateFin);
        $stmt->execute();

        $rdvs = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $rdvs[] = new Rdv(
                id: $row['id'],
                praticien_id: $row['praticien_id'],
                patient_id: $row['patient_id'],
                date_heure_debut: $row['date_heure_debut'],
                status: (int) $row['status'],
                duree: (int) $row['duree'],
                date_heure_fin: $row['date_heure_fin'],
                date_creation: $row['date_creation'],
                motif_visite: $row['motif_visite']
            );
        }

        return $rdvs;
    }
}
