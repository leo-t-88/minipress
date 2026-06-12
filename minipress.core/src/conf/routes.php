<?php
declare(strict_types=1);

use Slim\App;
use mp\webui\actions\GetHomeAction;
use mp\webui\actions\GetSigninAction;
use mp\webui\actions\PostSigninAction;
use mp\webui\actions\GetCreateArticleAction;
use mp\webui\actions\PostCreateArticleAction;
use mp\webui\actions\PostTooglePublishArticleAction;
use mp\webui\actions\GetArticlesListAction;
use mp\webui\actions\LogoutAction;
use mp\webui\actions\GetCreateCategorieAction;
use mp\webui\actions\PostCreateCategorieAction;

// Use Api
use mp\api\ApiCategories;
use mp\api\ApiArticleId;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');
    $app->get('/signin', GetSigninAction::class)->setName('signin');
    $app->post('/signin', PostSigninAction::class)->setName('signin_post');
    $app->get('/article/create', GetCreateArticleAction::class)->setName('form_article');
    $app->post('/article/create', PostCreateArticleAction::class)->setName('post_article');
    $app->post('/article/toogle_publish/{id}', PostTooglePublishArticleAction::class)->setName('article_toggle_publish');
    $app->get('/articles', GetArticlesListAction::class)->setName('liste_articles');
    $app->get('/logout', LogoutAction::class)->setName('logout');
    $app->get('/categorie/create', GetCreateCategorieAction::class)->setName('categorie_create');
    $app->post('/categorie/create', PostCreateCategorieAction::class)->setName('categorie_store');

    // Api
    $app->get('/api/categories', ApiCategories::class )->setName('api_categories');
    $app->get('/api/articles/{id}', ApiArticleId::class )->setName('api_article_id');
    return $app;
};
