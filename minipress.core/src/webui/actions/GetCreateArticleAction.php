<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use mp\core\domain\entities\Categorie;

use mp\webui\providers\CsrfTokenProvider;

class GetCreateArticleAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categories = Categorie::all();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'create_article.twig', [
            'categories' => $categories,
            'csrf_token' => CsrfTokenProvider::generate()
        ]);
    }
}