<?php
declare(strict_types=1);

namespace mp\webui\providers;

use mp\core\application\usecases\AuthnService;
use mp\core\application\exceptions\NotLoggedException;

class AuthnProvider
{
    public static function signin(string $email, string $password): void
    {
        $user = (new AuthnService())->signin($email, $password);
        $_SESSION['user_id'] = $user['id'];
    }

    public static function getSignedInUser(): int
    {
        if (!isset($_SESSION['user_id'])) throw new NotLoggedException("Non authentifié");

        return (int) $_SESSION['user_id'];
    }

    public static function signout(): void
    {
        unset($_SESSION['user_id']);
    }
}
