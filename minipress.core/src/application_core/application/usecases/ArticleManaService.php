<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use mp\core\domain\entities\Article;


interface ArticleManaService extends ArticleManaInterface
{

      public function createArticle(string $titre, ?string $resume, string $contenu, string $createur_id): array
      {
            //verifier si il est connecté

            try {
                  $article = new Article();
                  $article->id = bin2hex(random_bytes(16));
                  $article->titre = $titre;
                  $article->resume = $resume;
                  $article->contenu = $contenu;
                  $article->auteur_id = $createur_id;
                  $article->categorie_id = null;

            } catch (Exception $e) {
                  throw new DataErrorException("Erreur lors de la création de l'article " . $e->getMessage());
            }
      }

      public function getArticle(string $id): array
      {
            try {
                  $article = Article::with('id')->findOrFail($id);

                  return $article->toArray();
            } catch (ModelNotFoundException $e) {
                  throw new NotFoundException("Article non trouvée dans la base de donnée.");
            } catch (Exception $e) {
                  throw new DataErrorException("Erreur lors de la récupération de l'article");
            }
      }

      public function validateArticle(string $id): array
      {
            try {
                  $article = Article::with('id')->findOrFail($id);

                  $article->validate();
                  $article->save();

                  return $article->toArray();
            } catch (ModelNotFoundException $e) {
                  throw new NotFoundException("Box non trouvée dans la base de donnée.");
            } catch (Exception $e) {
                  throw new DataErrorException("Erreur lors de la validation de la box");
            }
      }
}
