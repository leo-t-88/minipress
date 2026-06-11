<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use mp\core\domain\entities\Article;
use mp\core\domain\entities\Categorie;

class GetArticlesListAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $categorie_id = filter_var($queryParams['categorie_id'] ?? null, FILTER_VALIDATE_INT);

        $query = Article::orderBy('date_creation', 'DESC');

        if ($categorie_id) {
            $query->where('categorie_id', $categorie_id);
        }

        $articles = $query->get();
        $categories = Categorie::all();

        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'list_articles.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'current_categorie_id' => $categorie_id
        ]);
    }
}