<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

use mp\webui\providers\CsrfTokenProvider;
use mp\webui\providers\AuthnProvider;
use mp\core\application\usecases\AuthzInterface;
use mp\core\application\usecases\AuthzService;
use mp\core\application\usecases\ArticleManaService;
use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;

class PostTooglePublishArticleAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $articleId = (int) $args['id'];
        $data = $request->getParsedBody();
        $csrf = $data['csrf_token'] ?? '';

        $authzService = new AuthzService();
        if (!$authzService->isGranted(AuthnProvider::getSignedInUser(), AuthzInterface::TOOGLE_ARTICLE, $articleId)) {
            throw new HttpForbiddenException($request, 'Action non autorisée');
        }
        
        try {
            CsrfTokenProvider::check($csrf);
            
            (new ArticleManaService())->togglePublication($articleId);
        } catch (CsrfException | DataErrorException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        } catch (NotFoundException $e) {
            throw new HttpNotFoundRequest($request, $e->getMessage());
        }

        return $response->withHeader('Location', RouteContext::fromRequest($request)->getRouteParser()->urlFor('liste_articles'))->withStatus(302);
    }
}