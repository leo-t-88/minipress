<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

use mp\webui\providers\CsrfTokenProvider;

class GetCreateCategorieAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return Twig::fromRequest($request)->render($response, 'categorieCreate.twig', [
            'csrf' => CsrfTokenProvider::generate()
        ]);
    }
}
