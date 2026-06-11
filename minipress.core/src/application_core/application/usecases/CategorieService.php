<?php
declare(strict_types=1);

namespace mp\core\application\usecases;

use mp\core\application\exceptions\DataErrorException;
use mp\core\domain\entities\Categorie;

class CategorieService implements CategorieInterface {
    public function createCategorie(string $label): array {
        $label = trim($label);

        if ($label === '') {
            throw new DataErrorException('Le nom de la catégorie est obligatoire');
        }

        $existing = Categorie::where('nom', '=', $label)->first();

        if ($existing) {
            throw new DataErrorException('Cette catégorie existe déjà');
        }

        $categorie = new Categorie();
        $categorie->nom = $label;
        $categorie->save();

        return $categorie->toArray();
    }
    public function getAllCategories(): array{
        return Categorie::all()->toArray();
    }
}
