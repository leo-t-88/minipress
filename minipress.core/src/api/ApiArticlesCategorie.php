<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mp\core\application\exceptions\NotFoundException;
use Slim\Exception\HttpNotFoundException;
use mp\core\application\usecases\ArticleManaService;

class ApiArticlesCategorie {
    public function __invoke(Request $request, Response $response, array $args): Response {
        try {
            $id = (int) $args['id'];
            $articles = (new ArticleManaService())->getArticleByCategorie($id);

            $data = [
                'type' => 'collection',
                'count' => count($articles),
                'articles' => $articles
            ];

            $response->getBody()->write(json_encode($data));
            return $response->withHeader("Content-Type", "application/json");

        } catch (NotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}
