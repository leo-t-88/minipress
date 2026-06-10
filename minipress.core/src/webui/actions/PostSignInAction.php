<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

use mp\webui\providers\AuthnProvider;
use mp\webui\providers\CsrfTokenProvider;

use mp\core\application\exceptions\CsrfException;
use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;
use Slim\Exception\HttpBadRequestException;

class PostSigninAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $data['password'] ?? '';
        $csrf = $data['csrf'] ?? '';

        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new HttpBadRequestException('Invalid email format');
            }

            CsrfTokenProvider::check($csrf);
            AuthnProvider::signin($email, $password);

            return $response
                ->withHeader('Location', '/mp-admin/')
                ->withStatus(302);

        } catch (CsrfException | NotFoundException | DataErrorException $e) {
            return Twig::fromRequest($request)->render($response, 'signin.twig', [
                'error' => $e->getMessage(),
                'csrf' => CsrfTokenProvider::generate()
            ]);
        }
    }
}
