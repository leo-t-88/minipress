<?php
declare(strict_types=1);

use Slim\App;
use mp\webui\actions\GetHomeAction;
use mp\webui\actions\GetSigninAction;
use mp\webui\actions\PostSigninAction;
use mp\webui\actions\LogoutAction;
use mp\webui\actions\GetCreateCategorieAction;
use mp\webui\actions\PostCreateCategorieAction;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');
    $app->get('/signin', GetSigninAction::class)->setName('signin');
    $app->post('/signin', PostSigninAction::class)->setName('signin.post');
    $app->get('/logout', LogoutAction::class)->setName('logout');
    $app->get('/categories/create', GetCreateCategorieAction::class)->setName('categorie.create');
    $app->post('/categories/create', PostCreateCategorieAction::class)->setName('categorie.store');
    return $app;
};
