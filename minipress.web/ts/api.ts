import { API_BASE_URL, API_PATH } from "./config";
import { ArticleList, CategoryList } from "./types";

export async function getArticles(): Promise<ArticleList> {
    const response = await fetch(`${API_BASE_URL}${API_PATH}/articles`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des articles");
    }

    return response.json() as Promise<ArticleList>;
}

export async function getArticlesByCategorie(id: string): Promise<ArticleList> {
    const response = await fetch(`${API_BASE_URL}${API_PATH}/categories/${id}/articles`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des articles");
    }

    return response.json() as Promise<ArticleList>;
}

export async function getCategories(): Promise<CategoryList> {
    const response = await fetch(`${API_BASE_URL}${API_PATH}/categories`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des catégories");
    }

    return response.json() as Promise<CategoryList>;
}

export async function getArticle(lien: string) {
    const response = await fetch(API_BASE_URL + lien);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement de l'article");
    }

    return response.json();
}

export async function getArticlesAuteur(id: string): Promise<ArticleList> {
    const response = await fetch(`${API_BASE_URL}${API_PATH}/auteurs/${id}/articles`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des articles de l'auteur");
    }

    return response.json() as Promise<ArticleList>;
}