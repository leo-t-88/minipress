<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Exception\HttpUnauthorizedException;

use mp\core\application\exceptions\AuthnException;
use mp\core\application\usecases\ArticleManaService;
use mp\core\application\usecases\CategorieService;
use mp\webui\providers\CsrfTokenProvider;
use mp\webui\providers\AuthnProvider;

class GetCreateArticleAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try{
            AuthnProvider::getSignedInUser();
        } catch (AuthnException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        }

        $categories = (new CategorieService)->getAllCategories();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'create_article.twig', [
            'categories' => $categories,
            'csrf_token' => CsrfTokenProvider::generate()
        ]);
    }
}