<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;
use Slim\exception\HttpForbiddenException;
use Slim\exception\HttpBadRequestException;

use mp\webui\providers\CsrfTokenProvider;
use mp\webui\providers\AuthnProvider;
use mp\core\application\usecases\AuthzInterface;
use mp\core\application\usecases\AuthzService;
use mp\core\application\usecases\CategorieService;
use mp\core\application\exceptions\CsrfException;
use mp\core\application\exceptions\DataErrorException;

class PostCreateCategorieAction {
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $label = trim($data['label'] ?? '');
        $csrf = $data['csrf_token'] ?? '';

        $authzService = new AuthzService();
        if (!$authzService->isGranted(AuthnProvider::getSignedInUser(), AuthzInterface::CREATE_CATEGORY)) {
            throw new HttpForbiddenException($request, 'Action non autorisée');
        }

        try {
            CsrfTokenProvider::check($csrf);

            $service = new CategorieService();
            $service->createCategorie($label);

            return $response
                ->withHeader(
                    'Location',
                    RouteContext::fromRequest($request)->getRouteParser()->urlFor('home')
                )
                ->withStatus(302);

        } catch (CsrfException | DataErrorException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }
    }
}
