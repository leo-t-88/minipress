<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Connexion BD
use mp\infra\Eloquent;
Eloquent::init(__DIR__ . '/minipress.db.conf.ini');

use \Slim\App;
use mp\webui\actions\GetHomeAction;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');

    return $app;
};
