<?php
declare(strict_types=1);
namespace mp\core\application\usecases;

use mp\core\application\exceptions\DataErrorException;
use mp\core\application\exceptions\NotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use mp\core\domain\entities\Article;
use mp\core\domain\entities\User;

class ArticleManaService implements ArticleManaInterface
{
      public function createArticle(string $titre, ?string $resume, string $contenu, int $createur_id, ?int $categorie_id = null): array
      {
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
                  throw new NotFoundException("Article non trouvée dans la base de donnée.");
            } catch (Exception $e) {
                  throw new DataErrorException("Erreur lors de la validation de la Article");
            }
      }

      public function getArticles($userId, ?int $categorie_id = null){
            try {
                  $user = User::findOrFail($userId);

                  $articles = Article::orderBy('date_creation', 'DESC');

                  if ($user->role < 50) $articles->where('auteur_id', $user->id);
                  if ($categorie_id !== null) $articles->where('categorie_id', $categorie_id);

                  return $articles->get()->toArray();
            } catch (ModelNotFoundException $e) {
                  throw new NotFoundException("Article non trouvée dans la base de donnée.");
            } catch (Exception $e) {
                  throw new DataErrorException("Erreur lors de la validation de la box");
            }
      }
}
