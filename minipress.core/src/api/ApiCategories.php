<?php
declare(strict_types=1);

namespace mp\api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use mp\core\application\usecases\CategorieService;
use Slim\Routing\RouteContext;


class ApiCategories
{
    public function __invoke(Request $request,Response $response): Response {

        $categories = (new CategorieService())->getAllCategories();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $data = [
            "type" => "collection",
            "count" => count($categories),
            "categories" => $categories,
        ];

        $response->getBody()->write(json_encode($data));

        return $response->withHeader("Content-Type", "application/json");
    }
}
