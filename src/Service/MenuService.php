<?php

namespace App\Service;

use App\Repository\MenuRepository;

class MenuService
{
    public function __construct(
        private MenuRepository $menuRepository
    ){
    }

    public function findAll(): array
    {
        return $this->menuRepository->findAllForTwig();
    }
}