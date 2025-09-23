<?php

namespace toubilib\core\domain\entities;
class Rdv{

    private string $id;
    private string $praticien_id;
    private string $patient_id;
    private ?string $email;
    private string $date_heure_debut;
    private int $status;
    private int $duree;
    private string $date_heure_fin;
    private string $date_creation;
    private string $motif_visite;

    public function  __construct(
        string $id,
        string $praticien_id,
        string $patient_id,
        string $date_heure_debut,
        int $status,
        int $duree,
        string $date_heure_fin,
        string $date_creation,
        string $motif_visite
    ){
        $this->id = $id;
        $this->praticien_id = $praticien_id;
        $this->patient_id = $patient_id;
        $this->date_heure_debut = $date_heure_debut;
        $this->status = $status;
        $this->duree = $duree;
        $this->date_heure_fin = $date_heure_fin;
        $this->date_creation = $date_creation;
        $this->motif_visite = $motif_visite;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPraticienId(): string
    {
        return $this->praticien_id;
    }

    public function getPatientId(): string
    {
        return $this->patient_id;
    }

    public function getDateHeureDebut(): string
    {
        return $this->date_heure_debut;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getDuree(): int
    {
        return $this->duree;
    }

    public function getDateHeureFin(): string
    {
        return $this->date_heure_fin;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getMotifVisite(): string
    {
        return $this->motif_visite;
    }

}