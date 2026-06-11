<?php
declare(strict_types=1);

namespace mp\core\application\usecases;

use mp\core\application\exceptions\AuthnException;
use mp\core\domain\entities\User;

class AuthnService implements AuthnInterface
{
    public function signin(string $email, string $password): array
    {
        $user = User::where('email', '=', $email)->first();
        
        if (!$user) throw new AuthnException("Utilisateur inexistant");
        if (!password_verify($password, $user->password)) throw new AuthnException("Credentials invalides");

        return $user->toArray();
    }
}
