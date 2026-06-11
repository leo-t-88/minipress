<?php
declare(strict_types=1);

namespace mp\webui\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

use mp\webui\providers\CsrfTokenProvider;

use mp\core\application\usecases\CategorieService;
use mp\core\application\exceptions\CsrfException;
use mp\core\application\exceptions\DataErrorException;

class PostCreateCategorieAction {
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();

        $label = trim($data['label'] ?? '');
        $csrf = $data['csrf'] ?? '';

        try {
            CsrfTokenProvider::check($csrf);

            $service = new CategorieService();
            $service->createCategorie($label);

            return $response
                ->withHeader(
                    'Location',
                    RouteContext::fromRequest($request)->getRouteParser()->urlFor('home')
                )
                ->withStatus(302);

        } catch (CsrfException | DataErrorException $e) {
            return Twig::fromRequest($request)->render($response, 'categorieCreate.twig', [
                'error' => $e->getMessage(),
                'csrf' => CsrfTokenProvider::generate(),
                'old_label' => $label
            ]);
        }
    }
}
