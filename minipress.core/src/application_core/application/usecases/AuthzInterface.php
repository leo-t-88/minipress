<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface AuthzInterface
{
    public const CREATE_ARTICLE = 'create_article';
    public const REGISTER_USER = 'register_user';
    public const CREATE_CATEGORY = 'create_category';
    public function isGranted(int $user_id, string $operation, ?string $article_id): bool;
}