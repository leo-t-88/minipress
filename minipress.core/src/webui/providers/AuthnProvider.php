<?php
declare(strict_types=1);

namespace mp\webui\providers;

use mp\core\application\usecases\AuthnService;
use mp\core\application\exceptions\AuthnException;

class AuthnProvider
{
    public const ROLE_NAME = [
        1 => "Auteur",
        50 => "Admin",
        100 => "Super Admin"
    ];

    public static function signin(string $email, string $password): void
    {
        $user = (new AuthnService())->signin($email, $password);
        $_SESSION['user_id'] = $user['id'];
    }

    public static function getSignedInUser(): int
    {
        if (!isset($_SESSION['user_id'])) throw new AuthnException("Non authentifié");

        return (int) $_SESSION['user_id'];
    }

    public static function signout(): void
    {
        unset($_SESSION['user_id']);
    }
    public static function register(string $nom, string $email, string $password, int $role): void
    {
        (new AuthnService())->createUser($nom, $email, $password, $role);
    }
}
