<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mp\core\application\exceptions\NotFoundException;
use Slim\Exception\HttpNotFoundException;
use mp\core\application\usecases\ArticleManaService;

class ApiArticles
{
    public function __invoke(Request $request, Response $response, array $args): Response {
        try {    
            $articles = (new ArticleManaService())->getArticles();

            $data = [
                'type' => 'collection',
                'count' => count($articles),
                'articles' => []
            ];

            foreach ($articles as $a) {
                $data['articles'][] = [
                    'article' => [
                        'id' => $a['id'],
                        'titre' => $a['titre'],
                        'resume' => $a['resume'],
                        'contenu' => $a['contenu'],
                        'date_creation' => $a['date_creation'],
                        'date_publication' => $a['date_publication'],
                        'auteur_id' => $a['auteur_id'],
                        'categorie_id' => $a['categorie_id']
                    ],
                    'links' => [
                        'self' => [
                            'href' => '/articles/' . $a['id'] . '/'
                        ]
                    ]
                ];
            }

            $response->getBody()->write(json_encode($data));

            return $response->withHeader('Content-Type', 'application/json');
        } catch (NotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}
