<?php
declare(strict_types=1);

session_start();

use mp\infra\Eloquent;
use \Slim\Views\Twig;
use \Slim\Views\TwigMiddleware;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use mp\core\domain\entities\User;

Eloquent::init(__DIR__ . '/minipress.db.conf.ini');

$app = \Slim\Factory\AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(false, false, false);
$app->setBasePath('');
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    // Enable CORS headers for GET and POST
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
});

$user = null;

try {
    if (isset($_SESSION['user_id'])) {
        $user = User::findOrFail($_SESSION['user_id']);
        if ($user) {
            $role = (int) $user['role'];

            if ($role === 100) {
                $user['role_name'] = 'Super Admin';
            } elseif ($role >= 50) {
                $user['role_name'] = 'Admin';
            } else {
                $user['role_name'] = 'Auteur';
            }
        }
    }
} catch (ModelNotFoundException $e) {
    unset($_SESSION['user_id']);
    $user = null;
}

$twig = Twig::create(__DIR__ . '/../webui/views', [
    'cache' => __DIR__ . '/../app/views/cache',
    'auto_reload' => true,
]);

$twig->getEnvironment()->addGlobal('css_path', $app->getBasePath() . '/css');
$twig->getEnvironment()->addGlobal('version', ['mp' => '1.0.0', 'php' => PHP_VERSION]);
$twig->getEnvironment()->addGlobal('user', $user);
$twig->getEnvironment()->addGlobal('menu', [
    ['label' => 'Accueil', 'route' => 'home'],
    ['label' => 'Articles', 'route' => 'liste_articles'],
    ['label' => 'Créer un article', 'route' => 'create_article'],
    ['label' => 'Créer une catégorie', 'route' => 'create_categorie'],
    ['label' => 'Créer un utilisateur', 'route' => 'create_user']
]);

$app->add(TwigMiddleware::create($app, $twig));

$app = (require_once __DIR__ . '/routes.php')($app);

return $app;
