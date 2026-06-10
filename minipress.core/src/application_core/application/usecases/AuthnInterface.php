<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

interface AuthnInterface {
    public function signin(string $user_id, string $password): array;
}
