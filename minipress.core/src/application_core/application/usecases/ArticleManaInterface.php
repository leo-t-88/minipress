<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface ArticleManaInterface {

    public function createArticle(string $titre, string $resume, string $contenu, string $createur_id): array;

    public function getArticle(string $id): array;

    public function validateArticle(string $id): array;
}
