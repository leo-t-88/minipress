<?php
declare(strict_types=1);

session_start();

use mp\infra\Eloquent;
use \Slim\Views\Twig;
use \Slim\Views\TwigMiddleware;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use mp\core\domain\entities\User;

Eloquent::init(__DIR__ . '/minipress.db.conf.ini');

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->setBasePath('/mp-admin');

$user = null;

try {
    if (isset($_SESSION['user_id'])) {
        $user = User::findOrFail($_SESSION['user_id']);
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
$twig->getEnvironment()->addGlobal('user', $user);

$app->add(TwigMiddleware::create($app, $twig));

$app = (require_once __DIR__ . '/routes.php')($app);

return $app;
