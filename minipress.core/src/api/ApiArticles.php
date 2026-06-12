<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mp\core\application\exceptions\NotFoundException;
use Slim\Exception\HttpNotFoundException;
use mp\core\application\usecases\ArticleManaService;
use Slim\Routing\RouteContext;

class ApiArticles
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $articles = (new ArticleManaService())->getArticles();
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            $queryParams = $request->getQueryParams();
            $sort = $queryParams['sort'] ?? null;
            $articles = match ($sort) {
                'date_asc' => $this->trierParDate($articles, true),
                'date_desc' => $this->trierParDate($articles, false),
                'auteur' => $this->trierParAuteur($articles),
                default => $articles
            };

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
                            'href' => $routeParser->urlFor("api_articles") . "/" . $a['id'] . '/'
                        ]
                    ],
                ];
            }

            $response->getBody()->write(json_encode($data));

            return $response->withHeader('Content-Type', 'application/json');
        } catch (NotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }

    private function trierParDate(array $liste, bool $asc): array
    {
        usort($liste, function ($a, $b) use ($asc) {
            if (empty($a['date_publication']))
                return 1;
            if (empty($b['date_publication']))
                return -1;
            return $asc ? strtotime($a['date_publication']) - strtotime($b['date_publication']) : strtotime($b['date_publication']) - strtotime($a['date_publication']);
        });
        return $liste;
    }

    private function trierParAuteur(array $liste): array
    {
        usort($liste, fn($a, $b) => $a['auteur_id'] - $b['auteur_id']);
        return $liste;
    }
}
