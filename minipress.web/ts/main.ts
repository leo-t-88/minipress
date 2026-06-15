
import { getArticles, getCategories, getArticlesByCategorie } from "./api";
import { renderArticles, renderCategories } from "./view";
import { ArticleList } from "./types";

async function init(): Promise<void> {
    const zoneArticles = document.getElementById("articles");
    const zoneCategories = document.getElementById("categories-list");

    try {
        const response: ArticleList = await getArticles();

        const sortedArticles = response.articles.sort(
            (a: ArticleList["articles"][number], b: ArticleList["articles"][number]) =>
                new Date(b.article.date_creation).getTime() -
                new Date(a.article.date_creation).getTime()
        );

        renderArticles(sortedArticles);
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }

    try {
        const response = await getCategories();
        renderCategories(response.categories);
        if (zoneCategories) {
            zoneCategories.addEventListener("click", (event) => {
                const target = event.target as HTMLElement;
                const item = target.closest(".categorie-item") as HTMLElement | null;

                if (!item) return;

                const id = item.dataset.id;
                if (!id) return;

                chargerArticlesCategorie(id);
            });
        }
    } catch (error) {
        console.error(error);
        if (zoneCategories) zoneCategories.innerHTML = "<p>Erreur de chargement des catégories</p>";
    }
}

async function chargerArticlesCategorie(id: string): Promise<void> {
    const zoneArticles = document.getElementById("articles");
    if (zoneArticles) zoneArticles.innerHTML = "<p>Chargement...</p>";

    try {
        const response = await getArticlesByCategorie(id);

        const sortedArticles = response.articles.sort(
            (a: any, b: any) =>
                new Date(b.article.date_creation).getTime() -
                new Date(a.article.date_creation).getTime()
        );

        renderArticles(sortedArticles);
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }
}

init();
