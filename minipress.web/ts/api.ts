import { API_BASE_URL_TEST } from "./config";

export async function getArticles() {
    const response = await fetch(`${API_BASE_URL_TEST}/articles`);

    if (!response.ok) {
        throw new Error("Erreur lors du chargement des articles");
    }

    return response.json();
}
