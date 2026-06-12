<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mp\webui\providers\AuthnProvider;
use mp\core\application\usecases\AuthzInterface;
use mp\core\application\usecases\AuthzService;
use mp\core\application\exceptions\AuthnException;
use Slim\Exception\HttpForbiddenException;
use Slim\Views\Twig;

use mp\webui\providers\CsrfTokenProvider;

class GetCreateUserAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try{
            $currentUserId = AuthnProvider::getSignedInUser();

            $authzService = new AuthzService();
            if (!$authzService->isGranted($currentUserId, AuthzInterface::REGISTER_USER)) {
                throw new HttpForbiddenException($request, "action non autorisée");
            }
        } catch (AuthnException $e) {
            throw new HttpForbiddenException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);

        return $view->render($response, 'create_user.twig', [
            'role' => AuthnProvider::ROLE_NAME,
            'csrf_token' => CsrfTokenProvider::generate()
        ]);
    }
}
