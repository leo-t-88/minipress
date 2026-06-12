<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use mp\core\application\usecases\ArticleManaService;

class ApiArticleId
{
    public function __invoke(Request $request, Response $response, array $args): Response {
<<<<<<< HEAD
        $id = (string) $args['id'];
=======
        $id = (int) $args['id'];
>>>>>>> publish_art
        $article = (new ArticleManaService())->getArticle($id);

        $data = [
            "type" => "resource",
            "article" => $article,
        ];

        $response->getBody()->write(json_encode($data));

        return $response->withHeader("Content-Type", "application/json");
    }
}
