
import { getArticles, getCategories } from "./api";
import { renderArticles, renderCategories } from "./view";

async function init(): Promise<void> {
    const zoneArticles = document.getElementById("articles");
    const zoneCategories = document.getElementById("categories-list");

    try {
        const response = await getArticles();

        const sortedArticles = response.articles.sort((a: any, b: any) => {
            return new Date(b.article.date_creation).getTime() - new Date(a.article.date_creation).getTime();
        });

        renderArticles(sortedArticles);
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }

    try {
        const response = await getCategories();
        renderCategories(response.categories);
    } catch (error) {
        console.error(error);
        if (zoneCategories) zoneCategories.innerHTML = "<p>Erreur de chargement des catégories</p>";
    }
}

init();
