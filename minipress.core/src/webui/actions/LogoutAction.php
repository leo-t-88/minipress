<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class LogoutAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        unset($_SESSION['user_id']);

        return $response->withHeader('Location', RouteContext::fromRequest($request)->getRouteParser()->urlFor('home'))->withStatus(302);
    }
}
