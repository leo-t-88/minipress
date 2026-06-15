import { API_BASE_URL } from "./config";
import { ArticleList } from "./types";

export async function getArticles(): Promise<ArticleList> {
    const response = await fetch(`${API_BASE_URL}/articles`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des articles");
    }

    return response.json() as Promise<ArticleList>;
}


export async function getArticlesByCategorie(id: string): Promise<any> {
  const response = await fetch(`${API_BASE_URL}/categories/${id}/articles`);
  if (!response.ok) {
    throw new Error("Erreur lors du chargement des articles");
  }
  return await response.json();
}

export async function getCategories() {
    const response = await fetch(`${API_BASE_URL}/categories`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des catégories");
    }
    return response.json();
}
