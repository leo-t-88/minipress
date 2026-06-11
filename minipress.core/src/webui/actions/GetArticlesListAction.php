<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use mp\core\domain\entities\Article;

class GetArticlesListAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $articles = Article::orderBy('date_creation', 'DESC')->get();

        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'list_articles.twig', [
            'articles' => $articles
        ]);
    }
}