<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\RdvDTO;
use toubilib\core\application\ports\api\ServiceRdvInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;

class ServiceRdv implements ServiceRdvInterface
{
    private RdvRepositoryInterface $rdvRepository;

    public function __construct(RdvRepositoryInterface $rdvRepository)
    {
        $this->rdvRepository = $rdvRepository;
    }

    public function listerRdv(): array
    {
        $rdvs = $this->rdvRepository->findAll();

        return array_map(function ($rdv) {
            return new RdvDTO(
                id: $rdv->getId(),
                praticien_id: $rdv->getPraticienId(),
                patient_id: $rdv->getPatientId(),
                date_heure_debut: $rdv->getDateHeureDebut(),
                status: $rdv->getStatus(),
                duree: $rdv->getDuree(),
                date_heure_fin: $rdv->getDateHeureFin(),
                date_creation: $rdv->getDateCreation(),
                motif_visite: $rdv->getMotifVisite()
            );
        }, $rdvs);
    }

    public function chercherParId(string $id): ?RdvDTO
    {
        $rdv = $this->rdvRepository->findById($id);

        if ($rdv === null) {
            return null;
        }

        return new RdvDTO(
            id: $rdv->getId(),
            praticien_id: $rdv->getPraticienId(),
            patient_id: $rdv->getPatientId(),
            date_heure_debut: $rdv->getDateHeureDebut(),
            status: $rdv->getStatus(),
            duree: $rdv->getDuree(),
            date_heure_fin: $rdv->getDateHeureFin(),
            date_creation: $rdv->getDateCreation(),
            motif_visite: $rdv->getMotifVisite()
        );
    }
}
