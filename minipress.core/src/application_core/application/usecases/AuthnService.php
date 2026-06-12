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
    public function createUser(string $nom, string $email, string $password, int $role): array
    {

        $existingUser = User::where('email', '=', $email)->first();

        if ($existingUser) {
            throw new AuthnException("Email déjà utilisé");
        }

        if (strlen($password) < 8) {
            throw new AuthnException("Le mot de passe doit faire au moins 8 caractères");
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password)) {
            throw new AuthnException("Le mot de passe doit contenir une majuscule et une minuscule");
        }

        $user = new User();
        $user->nom = $nom;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->role = $role;
        $user->save();

        return $user->toArray();
    }
}
