<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface ArticleManaInterface {

    public function createArticle(string $titre, ?string $resume, string $contenu, int $createur_id): array;

    public function getArticle(int $id): array;

    public function getArticleByCategorie(int $id): array;

    public function getArticleByAuteur(int $idd): array;

    public function togglePublication(int $id): void;

    public function getArticles(?int $categorie_id = null) : array;
}

