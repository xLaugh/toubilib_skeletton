<?php
namespace toubilib\core\application\ports\api;

interface ServiceRdvInterface {

    /**
     * @return RdvDTO[]
     */
    public function listerRdv(): array;

    /**
     * @return RdvDTO|null
     */
    public function chercherParId(string $id): ?RdvDTO;
    public function listerCreneauxOccupes(string $praticienId, string $dateDebut, string $dateFin): array;
}
