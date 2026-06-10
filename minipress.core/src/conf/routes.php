<?php
declare(strict_types=1);

use Slim\App;
use minipress\webui\actions\GetHomeAction;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');

    return $app;
};
