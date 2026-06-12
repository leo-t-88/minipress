<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface ArticleManaInterface {

    public function createArticle(string $titre, ?string $resume, string $contenu, int $createur_id): array;

    public function getArticle(string $id): array;

    public function validateArticle(string $id): array;
    
    public function getArticles(): array;

    public function getArticleByCategorie(int $id): array;
}

