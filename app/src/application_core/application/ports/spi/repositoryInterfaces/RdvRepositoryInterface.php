<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;


use toubilib\core\domain\entities\Rdv;

interface RdvRepositoryInterface {
public function findAll(): array;
public function findById(string $id): ?Rdv;
}
