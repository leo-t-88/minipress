<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use mp\core\application\usecases\ArticleManaService;

class PostArticleAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $titre = filter_var($data['titre'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $resume = filter_var($data['resume'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $contenu = filter_var($data['contenu'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($titre) || empty($contenu)) {
            throw new \InvalidArgumentException("Le titre et le contenu sont obligatoires.");
        }

        // Si l'utilisateur laisse "-- Choisir une catégorie --"
        // l'ID sera vide : étape 1 ou 2 à choisir.
        $categorie_id = filter_var($data['categorie_id'] ?? null, FILTER_VALIDATE_INT);

        try {
            $article = (new ArticleManaService())->createArticle($titre, $resume, $contenu, $_SESSION['user_id']);    
            
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la sauvegarde de l'article : " . $e->getMessage());
        }

        $routeContext = RouteContext::fromRequest($request);

        $routeParser = $routeContext->getRouteParser(); 
        $url = $routeParser->urlFor('form_article');

        return $response->withHeader('Location', $url)->withStatus(302);    
    }
}