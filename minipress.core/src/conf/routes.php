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
use mp\webui\actions\GetCreateUserAction;
use mp\webui\actions\PostCreateUserAction;

// Use Api
use mp\api\ApiCategories;
use mp\api\ApiArticleId;
use mp\api\ApiArticles;
use mp\api\ApiArticlesCategorie;
use mp\api\ApiArticleAuteur;

return function (App $app): App {
    $app->get('/', GetHomeAction::class)->setName('home');
    $app->get('/signin', GetSigninAction::class)->setName('signin');
    $app->post('/signin', PostSigninAction::class)->setName('signin_post');
    $app->get('/article/create', GetCreateArticleAction::class)->setName('create_article');
    $app->post('/article/create', PostCreateArticleAction::class)->setName('create_article_post');
    $app->post('/article/toogle_publish/{id}', PostTooglePublishArticleAction::class)->setName('article_toggle_publish');
    $app->get('/articles', GetArticlesListAction::class)->setName('liste_articles');
    $app->get('/logout', LogoutAction::class)->setName('logout');
    $app->get('/categorie/create', GetCreateCategorieAction::class)->setName('create_categorie');
    $app->post('/categorie/create', PostCreateCategorieAction::class)->setName('create_categorie_post');
    $app->get('/user/create', GetCreateUserAction::class)->setName('create_user');
    $app->post('/user/create', PostCreateUserAction::class)->setName('create_user_post');

    // Api
    $app->get('/api/categories', ApiCategories::class )->setName('api_categories');
    $app->get('/api/articles', ApiArticles::class )->setName('api_articles');
    $app->get('/api/articles/{id_a}', ApiArticleId::class )->setName('api_article_id');
    $app->get('/api/categories/{id_categ}/articles', ApiArticlesCategorie::class )->setName('api_articles_categorie');
    $app->get('/api/auteurs/{id}/articles', ApiArticleAuteur::class )->setName('api_articles_auteur');
    return $app;
};
