<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mp\core\application\exceptions\NotFoundException;
use Slim\Exception\HttpNotFoundException;
use mp\core\application\usecases\ArticleManaService;
use Slim\Routing\RouteContext;

class ApiArticlesCategorie {
    public function __invoke(Request $request, Response $response, array $args): Response {
        try {
            $id = (int) $args['id_categ'];
            $articles = (new ArticleManaService())->getArticleByCategorie($id);
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            $data = [
                'type' => 'collection',
                'count' => count($articles),
                'articles' => []
            ];

            foreach ($articles as $a) {
                $data['articles'][] = [
                    'article' => [
                        'titre' => $a['titre'],
                        'date_creation' => $a['date_creation'],
                        'auteur_id' => $a['auteur_id']
                    ],
                    'links' => [
                        'self' => [
                            'href' => $routeParser->urlFor("api_article_id", ['id_a' => $a['id']])
                        ]
                    ]
                ];
            }

            $response->getBody()->write(json_encode($data));
            return $response->withHeader("Content-Type", "application/json");

        } catch (NotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}
