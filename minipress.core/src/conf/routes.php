<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Connexion BD
use gift\infra\Eloquent;
Eloquent::init(__DIR__ . '/minipress.db.conf.ini');

use \Slim\App;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');

    return $app;
};
