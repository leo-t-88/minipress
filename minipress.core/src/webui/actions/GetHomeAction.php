<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

use mp\webui\providers\AuthnProvider;
use mp\core\application\exceptions\AuthnException;

class GetHomeAction
{
      public function __invoke(Request $request, Response $response, array $args): Response
      {
            try {
                  AuthnProvider::getSignedInUser();

                  $view = Twig::fromRequest($request);

                  return $view->render($response, 'homeView.twig');
            } catch (AuthnException $e) {
                  return $response->withHeader('Location', RouteContext::fromRequest($request)->getRouteParser()->urlFor('signin'))->withStatus(302);
            }
      }
}
