<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface AuthzInterface
{
    public const CREATE_ARTICLE = 'create_article';
    public const VIEW_ARTICLES = 'view_articles';
    public const CREATE_CATEGORY = 'create_category';
    public function isGranted(string $user_id, string $operation, string $article_id): bool;
}