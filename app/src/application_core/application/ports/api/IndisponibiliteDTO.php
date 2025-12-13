<?php

namespace toubilib\core\application\ports\api;

class IndisponibiliteDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $praticien_id,
        public readonly string $date_debut,
        public readonly string $date_fin,
        public readonly ?string $raison,
        public readonly ?string $date_creation
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'praticien_id' => $this->praticien_id,
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'raison' => $this->raison,
            'date_creation' => $this->date_creation,
        ];
    }
}

