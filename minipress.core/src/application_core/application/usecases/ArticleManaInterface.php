<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface ArticleManaInterface {

    public function createArticle(string $titre, ?string $resume, string $contenu, int $createur_id): array;

    public function togglePublication(int $id): void;

    public function getArticle(int $id, bool $onlyPubli = true): array;

    public function getArticles(?int $categorie_id = null, ?string $sort = null, bool $onlyPubli = true) : array;

    public function getArticleByAuteur(int $idd, bool $onlyPubli = true): array;

    public static function sanitizeMarkdown(string $md): string;
}

