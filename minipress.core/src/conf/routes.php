<?php
declare(strict_types=1);

use Slim\App;
use mp\webui\actions\GetHomeAction;
use mp\webui\actions\GetSigninAction;
use mp\webui\actions\PostSigninAction;
use mp\webui\actions\GetCreateArticleAction;
use mp\webui\actions\PostCreateArticleAction;
use mp\webui\actions\GetArticlesListAction;
use mp\webui\actions\LogoutAction;
use mp\webui\actions\GetCreateCategorieAction;
use mp\webui\actions\PostCreateCategorieAction;

// Use Api
use mp\api\ApiCategories;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');
    $app->get('/signin', GetSigninAction::class)->setName('signin');
    $app->post('/signin', PostSigninAction::class)->setName('signin_post');
    $app->get('/article/create', GetCreateArticleAction::class)->setName('form_article');
    $app->post('/article/create', PostCreateArticleAction::class)->setName('post_article');
    $app->get('/articles', GetArticlesListAction::class)->setName('liste_articles');
    $app->get('/logout', LogoutAction::class)->setName('logout');
    $app->get('/categories/create', GetCreateCategorieAction::class)->setName('categorie_create');
    $app->post('/categories/create', PostCreateCategorieAction::class)->setName('categorie_store');

    // Api
    $app->get('/api/categories', ApiCategories::class )->setName('api_categories');

    return $app;
};
