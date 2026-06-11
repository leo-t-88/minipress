<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

use mp\webui\providers\AuthnProvider;
use mp\webui\providers\CsrfTokenProvider;

use mp\core\application\exceptions\CsrfException;
use mp\core\application\exceptions\AuthnException;
use Slim\Exception\HttpBadRequestException;

class PostSigninAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $data['password'] ?? '';
        $csrf = $data['csrf'] ?? '';

        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new HttpBadRequestException($request, 'Invalid email format');
            }

            CsrfTokenProvider::check($csrf);
            AuthnProvider::signin($email, $password);

            return $response->withHeader('Location', RouteContext::fromRequest($request)->getRouteParser()->urlFor('home'))->withStatus(302);

        } catch (CsrfException | AuthnException | HttpBadRequestException $e) {
            return Twig::fromRequest($request)->render($response, 'signin.twig', [
                'error' => $e->getMessage(),
                'csrf' => CsrfTokenProvider::generate()
            ]);
        }
    }
}
