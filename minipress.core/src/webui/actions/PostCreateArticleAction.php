<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpBadRequest;

use mp\webui\providers\CsrfTokenProvider;
use mp\webui\providers\AuthnProvider;
use mp\core\application\usecases\AuthzInterface;
use mp\core\application\usecases\AuthzService;
use mp\core\application\usecases\ArticleManaService;
use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;

class PostCreateArticleAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $csrf = $data['csrf_token'] ?? '';

        $titre = filter_var($data['titre'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $resume = $data['resume'];
        $contenu = $data['contenu'];
        $categorie_id = filter_var($data['categorie_id'] ?? null, FILTER_VALIDATE_INT);
        if ($categorie_id === false) $categorie_id = null;
        
        if (empty($titre) || empty($contenu)) {
            throw new HttpBadRequest("Le titre et le contenu sont obligatoires.");
        }

        $authzService = new AuthzService();
        if (!$authzService->isGranted(AuthnProvider::getSignedInUser(), AuthzInterface::CREATE_ARTICLE)) {
            throw new HttpForbiddenException($request, 'Action non autorisée');
        }
        
        try {
            CsrfTokenProvider::check($csrf);
            
            $article = (new ArticleManaService())->createArticle($titre, $resume, $contenu, (int)$_SESSION['user_id'], $categorie_id);  
        } catch (CsrfException | DataErrorException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        } catch (NotFoundException $e) {
            throw new HttpNotFoundRequest($request, $e->getMessage());
        }

        $routeContext = RouteContext::fromRequest($request);

        $routeParser = $routeContext->getRouteParser(); 
        $url = $routeParser->urlFor('liste_articles');

        return $response->withHeader('Location', $url)->withStatus(302);    
    }
}