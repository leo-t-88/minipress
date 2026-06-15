import { API_BASE_URL } from "./config";

export async function getArticles() {
    const response = await fetch(`${API_BASE_URL}/articles`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des articles");
    }

    return response.json();
}

export async function getCategories() {
    const response = await fetch(`${API_BASE_URL}/categories`);
    
    if (!response.ok) {
        throw new Error("Erreur lors du chargement des catégories");
    }
    return response.json();
}