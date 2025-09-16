<?php

namespace toubilib\infra\repositories;

use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\domain\entities\praticien\Praticien;
use Ramsey\Uuid\Uuid;

class PDOPraticienRepository implements PraticienRepositoryInterface
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "
            SELECT 
                p.id,
                p.nom,
                p.prenom,
                p.ville,
                p.email,
                p.telephone,
                p.specialite_id,
                p.structure_id,
                p.rpps_id,
                p.organisation,
                p.nouveau_patient,
                p.titre,
                s.libelle as specialite_libelle
            FROM praticien p
            LEFT JOIN specialite s ON p.specialite_id = s.id
            ORDER BY p.nom, p.prenom
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        $praticiens = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $praticiens[] = new Praticien(
                id: Uuid::fromString($row['id']),
                nom: $row['nom'],
                prenom: $row['prenom'],
                ville: $row['ville'],
                email: $row['email'],
                telephone: $row['telephone'],
                specialiteId: (int) $row['specialite_id'],
                specialiteLibelle: $row['specialite_libelle'] ?? 'Non spécifiée',
                structureId: $row['structure_id'] ? Uuid::fromString($row['structure_id']) : null,
                rppsId: $row['rpps_id'],
                organisation: (bool) $row['organisation'],
                nouveauPatient: (bool) $row['nouveau_patient'],
                titre: $row['titre']
            );
        }

        return $praticiens;
    }

    public function findById(string $id): ?Praticien
    {
        $sql = "
            SELECT 
                p.id,
                p.nom,
                p.prenom,
                p.ville,
                p.email,
                p.telephone,
                p.specialite_id,
                p.structure_id,
                p.rpps_id,
                p.organisation,
                p.nouveau_patient,
                p.titre,
                s.libelle as specialite_libelle
            FROM praticien p
            LEFT JOIN specialite s ON p.specialite_id = s.id
            WHERE p.id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return new Praticien(
            id: Uuid::fromString($row['id']),
            nom: $row['nom'],
            prenom: $row['prenom'],
            ville: $row['ville'],
            email: $row['email'],
            telephone: $row['telephone'],
            specialiteId: (int) $row['specialite_id'],
            specialiteLibelle: $row['specialite_libelle'] ?? 'Non spécifiée',
            structureId: $row['structure_id'] ? Uuid::fromString($row['structure_id']) : null,
            rppsId: $row['rpps_id'],
            organisation: (bool) $row['organisation'],
            nouveauPatient: (bool) $row['nouveau_patient'],
            titre: $row['titre']
        );
    }
}