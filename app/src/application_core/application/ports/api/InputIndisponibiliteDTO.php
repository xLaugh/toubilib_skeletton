<?php

namespace toubilib\core\application\ports\api;

class InputIndisponibiliteDTO
{
    public function __construct(
        public string $praticien_id,
        public string $date_debut,
        public string $date_fin,
        public ?string $raison = null
    ) {}
}

