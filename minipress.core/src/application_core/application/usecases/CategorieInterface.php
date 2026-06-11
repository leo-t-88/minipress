<?php
declare(strict_types=1);
namespace mp\core\application\usecases;
interface CategorieInterface {
    public function createCategorie(string $label): array;
}
