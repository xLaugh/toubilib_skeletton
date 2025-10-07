<?php
declare(strict_types=1);

namespace toubilib\core\application\usecases;

use toubilib\core\application\ports\api\ProfileDTO;
use toubilib\core\application\ports\api\ServiceAuthzInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RdvRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\domain\entities\Rdv;

class ServiceAuthz implements ServiceAuthzInterface
{
    public const ROLE_PATIENT = 1;
    public const ROLE_PRATICIEN = 10;

    public function __construct(
        private readonly RdvRepositoryInterface $rdvRepository,
        private readonly PraticienRepositoryInterface $praticienRepository
    ) {
    }

    public function canAccessPraticienAgenda(ProfileDTO $profile, string $praticienId): bool
    {
        // Règles typiques:
        // - Un praticien peut accéder à son propre agenda
        // - Un patient peut accéder à l'agenda d'un praticien (disponibilités publiques)
        // Ici on autorise tous les rôles connus à consulter un agenda de praticien existant.
        // Si besoin de durcir: vérifier l'existence du praticien.

        $exists = $this->praticienRepository->findById($praticienId) !== null;
        if (!$exists) {
            return false;
        }

        return in_array($profile->role, [self::ROLE_PATIENT, self::ROLE_PRATICIEN], true);
    }

    public function canAccessRdvDetail(ProfileDTO $profile, string $rdvId): bool
    {
        $rdv = $this->rdvRepository->findById($rdvId);
        if ($rdv === null) {
            return false;
        }

        // Règles typiques:
        // - Le patient propriétaire du RDV peut voir le détail
        // - Le praticien propriétaire du RDV peut voir le détail
        if ($profile->role === self::ROLE_PATIENT) {
            return $rdv->getPatientId() === $profile->id;
        }

        if ($profile->role === self::ROLE_PRATICIEN) {
            return $rdv->getPraticienId() === $profile->id;
        }

        return false;
    }
}


