<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use mp\core\domain\entities\Article;


class ArticleManaService implements ArticleManaInterface
{

      public function createArticle(string $titre, ?string $resume, string $contenu, int $createur_id, ?int $categorie_id = null): array
      {
            //verifier si il est connecté

            try {
                  $article = new Article();
                  $article->titre = $titre;
                  $article->resume = $resume;
                  $article->contenu = $contenu;
                  $article->auteur_id = $createur_id;
                  $article->categorie_id = $categorie_id;

                  $article->save();

                  return $article->toArray();

            } catch (Exception $e) {
                  throw new DataErrorException("Erreur lors de la création de l'article " . $e->getMessage());
            }
      }

      public function getArticle(string $id): array
      {
            try {
                  $article = Article::findOrFail($id);
                  return $article->toArray();
            } catch (ModelNotFoundException $e) {
                  throw new NotFoundException("Article non trouvé dans la base de données.");
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

      public function getArticles(): array
      {
            return Article::all()->toArray();
      }

      public function getArticleByCategorie(int $id): array
      {
            return Article::all()->where('auteur_id', $id)->toArray();
      }
}
