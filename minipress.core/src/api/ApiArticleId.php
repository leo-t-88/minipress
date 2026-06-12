<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use mp\core\application\usecases\ArticleManaService;

class ApiArticleId
{
    public function __invoke(Request $request, Response $response, array $args): Response {
        $id = (int) $args['id_a'];
        $article = (new ArticleManaService())->getArticle($id);

        $data = [
            "type" => "resource",
            "article" => $article,
        ];

        $response->getBody()->write(json_encode($data));

        return $response->withHeader("Content-Type", "application/json");
    }
}
