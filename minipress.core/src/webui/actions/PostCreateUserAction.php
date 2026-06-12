<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use mp\core\application\exceptions\AuthnException;
use mp\core\application\usecases\AuthzService;
use mp\core\application\usecases\AuthzInterface;
use mp\webui\providers\AuthnProvider;
use mp\webui\providers\CsrfTokenProvider;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class PostCreateUserAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $nom = filter_var(trim($data['nom'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new HttpBadRequestException($request, "email invalide");
        $password = $data['password'] ?? '';
        $role = (int)($data['role'] ?? 1);
        if (!array_key_exists($role, AuthnProvider::ROLE_NAME)) throw new HttpBadRequestException($request, "rôle invalide");
        $csrf = $data['csrf_token'] ?? '';

        try {
            CsrfTokenProvider::check($csrf);

            $currentUserId = AuthnProvider::getSignedInUser();

            $authzService = new AuthzService();
            if (!$authzService->isGranted($currentUserId, AuthzInterface::REGISTER_USER)) {
                throw new HttpForbiddenException($request, "action non autorisée");
            }

            AuthnProvider::register($nom, $email, $password, $role);

            return $response->withHeader('Location', RouteContext::fromRequest($request)->getRouteParser()->urlFor('home'))->withStatus(302);

        } catch (AuthnException $e) {
            return Twig::fromRequest($request)->render($response, 'userCreate.twig', [
                'error' => $e->getMessage(),
                'csrf' => CsrfTokenProvider::generate(),
                'old_nom' => $nom,
                'old_email' => $email,
                'old_role' => $role,
            ]);
        }
    }
}
