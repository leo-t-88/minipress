<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

use Illuminate\Database\QueryException;
use gift\core\application\exceptions\DataErrorException;
use mp\core\domain\entities\User;
use mp\core\domain\entities\Article;

class AuthzService implements AuthzInterface
{
    public function isGranted(int $user_id, string $operation, ?string $article_id = null): bool
    {
        try {
            $user = User::where('id', $user_id)->first();
            switch ($operation) {
                case self::CREATE_ARTICLE:
                case self::CREATE_CATEGORY:
                    return $user['role'] >= 1;
                case self::REGISTER_USER:
                    return $user['role'] === 100;
            }
        } catch (QueryException $e) {
            throw new DataErrorException('Pas d\'article avec cette id');
        }
        return false;
    }
}