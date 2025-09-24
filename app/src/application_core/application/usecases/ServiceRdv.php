<?php

namespace toubilib\core\application\usecases;

use Ramsey\Uuid\Uuid;
use toubilib\core\application\ports\api\InputRendezVousDTO;
use toubilib\core\application\ports\api\RdvDTO;
use toubilib\core\application\ports\api\ServiceRdvInterface;
use toubilib\core\application\ports\api\RdvSlotDTO;
use toubilib\core\domain\entities\Rdv as RdvEntity;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;
use toubilib\core\domain\entities\Rdv;

class ServiceRdv implements ServiceRdvInterface
{
    private RdvRepositoryInterface $rdvRepository;
    private PraticienRepositoryInterface $praticienRepository;

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

    public function listerCreneauxOccupes(string $praticienId, string $dateDebut, string $dateFin): array
    {
        $rdvs = $this->rdvRepository->findByPraticienAndPeriod($praticienId, $dateDebut, $dateFin);
        return array_map(function ($rdv) {
            return new RdvSlotDTO(
                date_heure_debut: $rdv->getDateHeureDebut(),
                date_heure_fin: $rdv->getDateHeureFin()
            );
        }, $rdvs);
    }

    public function creerRendezVous(InputRendezVousDTO $dto): void
    {
        $praticien = $this->praticienRepository->findById($dto->praticien_id);
        if (!$praticien) {
            throw new \DomainException("Praticien inexistant");
        }

        if (!in_array($dto->motif_visite, $praticien->getMotifs())) {
            throw new \DomainException("Motif non autorisé");
        }

        $debut = new \DateTimeImmutable($dto->date_heure_debut);
        $fin = $debut->modify("+{$dto->duree} minutes");

        $jour = (int) $debut->format('N');
        $heure = (int) $debut->format('H');
        if ($jour > 5 || $heure < 8 || $heure >= 19) {
            throw new \DomainException("Créneau non valide (jour ouvré 8h–19h)");
        }

        $id = Uuid::uuid4()->toString();
        $dateCreation = date('Y-m-d H:i:s');

        $dateFin = date(
            'Y-m-d H:i:s',
            strtotime($dto->date_heure_debut . " +{$dto->duree} minutes")
        );

        $rdv = new Rdv(
            id: $id,
            praticien_id: $dto->praticien_id,
            patient_id: $dto->patient_id,
            date_heure_debut: $dto->date_heure_debut,
            status: 0,
            duree: $dto->duree,
            date_heure_fin: $dateFin,
            date_creation: $dateCreation,
            motif_visite: $dto->motif_visite
        );

        $this->rdvRepository->save($rdv);
    }

    public function agendaPraticien(string $praticienId, ?string $dateDebut = null, ?string $dateFin = null): array
    {
        if ($dateDebut === null || $dateFin === null) {
            $today = new \DateTimeImmutable('today');
            $start = $today->format('Y-m-d') . ' 00:00:00';
            $end = $today->format('Y-m-d') . ' 23:59:59';
            $dateDebut = $dateDebut ?? $start;
            $dateFin = $dateFin ?? $end;
        }
        $rdvs = $this->rdvRepository->findByPraticienAndPeriod($praticienId, $dateDebut, $dateFin);
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
}
