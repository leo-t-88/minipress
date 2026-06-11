<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

use mp\webui\providers\CsrfTokenProvider;

class GetCreateCategorieAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return Twig::fromRequest($request)->render($response, 'categorieCreate.twig', [
            'csrf' => CsrfTokenProvider::generate()
        ]);
    }
}
