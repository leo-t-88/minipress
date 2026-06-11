<?php
declare(strict_types=1);

use Slim\App;
use mp\webui\actions\GetHomeAction;
use mp\webui\actions\GetSigninAction;
use mp\webui\actions\PostSigninAction;
use mp\webui\actions\GetArticleFormAction;
use mp\webui\actions\PostArticleAction;
use mp\webui\actions\GetArticlesListAction;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');
    $app->get('/signin', GetSigninAction::class)->setName('signin');
    $app->post('/signin', PostSigninAction::class)->setName('signin.post');
    $app->get('/article/create', GetArticleFormAction::class)->setName('form_article');
    $app->post('/article/create', PostArticleAction::class)->setName('post_article');
    $app->get('/articles', GetArticlesListAction::class)->setName('liste_articles');

    return $app;
};
