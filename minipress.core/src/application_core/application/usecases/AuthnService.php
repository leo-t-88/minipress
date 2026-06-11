<?php
declare(strict_types=1);

namespace mp\core\application\usecases;

use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;
use mp\core\domain\entities\User;

class AuthnService implements AuthnInterface
{
    public function signin(string $email, string $password): array
    {
        $user = User::where('email', '=', $email)->first();

        if (!$user) {
            throw new NotFoundException("Utilisateur non trouvé");
        }

        if (!password_verify($password, $user->password)) {
            throw new DataErrorException("Mot de passe incorrect");
        }

        return $user->toArray();
    }
}
