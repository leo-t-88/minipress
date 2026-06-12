<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\exception\HttpUnauthorizedException;
use Slim\exception\HttpBadRequestException;
use Slim\exception\HttpNotFoundException;

use mp\core\application\exceptions\AuthnException;
use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;
use mp\core\application\usecases\ArticleManaService;
use mp\core\application\usecases\CategorieService;
use mp\core\application\usecases\AuthzInterface;
use mp\core\application\usecases\AuthzService;
use mp\webui\providers\AuthnProvider;
use mp\webui\providers\CsrfTokenProvider;

class GetArticlesListAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $categorie_id = filter_var($queryParams['categorie_id'] ?? null, FILTER_VALIDATE_INT);
        $categorie_id = ($categorie_id === false) ? null : $categorie_id;

        try{
            $userId = AuthnProvider::getSignedInUser();
            $articles = (new ArticleManaService)->getArticles($categorie_id, null, false);

            $authz = new AuthzService();
            foreach ($articles as $i => $article) $articles[$i]['can_toggle'] = $authz->isGranted($userId, AuthzInterface::TOOGLE_ARTICLE, $article['id']);
        } catch (AuthnException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        } catch (DataErrorException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        } catch (NotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        $categories = (new CategorieService)->getAllCategories();

        $view = Twig::fromRequest($request);
        
        return $view->render($response, 'list_articles.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'current_categorie_id' => $categorie_id,
            'csrf_token' => CsrfTokenProvider::generate()
        ]);
    }
}