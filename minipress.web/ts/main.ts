
import { getArticles, getCategories, getArticlesByCategorie } from "./api";
import { renderArticles, renderCategories } from "./view";
import { ArticleList } from "./types";

let displayedArticles: ArticleList["articles"] = [];

function sortAndRenderArticles(order: "ASC" | "DESC"): void {
    if (displayedArticles.length === 0) return;

    displayedArticles.sort((a, b) => {
        const timeA = new Date(a.article.date_creation).getTime();
        const timeB = new Date(b.article.date_creation).getTime();

        return order === "DESC" ? timeB - timeA : timeA - timeB;
    });

    renderArticles(displayedArticles);
}

async function init(): Promise<void> {
    const zoneArticles = document.getElementById("articles");
    const zoneCategories = document.getElementById("categories-list");
    const searchInput = document.getElementById("search-input") as HTMLInputElement | null;

    if (searchInput) {
        searchInput.addEventListener("input", () => {
            filterArticles(searchInput.value);
        });
    }

    try {
        const response: ArticleList = await getArticles();

        displayedArticles = response.articles;

        displayedArticles.sort(
            (a: ArticleList["articles"][number], b: ArticleList["articles"][number]) =>
                new Date(b.article.date_creation).getTime() -
                new Date(a.article.date_creation).getTime()
        );

        renderArticles(displayedArticles);
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

async function chargerArticlesCategorie(id: string): Promise<void> {
    const zoneArticles = document.getElementById("articles");
    if (zoneArticles) zoneArticles.innerHTML = "<p>Chargement...</p>";

    try {
        const response = await getArticlesByCategorie(id);

        displayedArticles = response.articles;
        displayedArticles.sort(
            (a: any, b: any) =>
                new Date(b.article.date_creation).getTime() -
                new Date(a.article.date_creation).getTime()
        );

        renderArticles(displayedArticles);
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }
}

const btnDesc = document.getElementById("btn-sort-desc");
const btnAsc = document.getElementById("btn-sort-asc");

    if (btnDesc && btnAsc) {
        btnDesc.addEventListener("click", () => {
            btnDesc.style.fontWeight = "bold";
            btnAsc.style.fontWeight = "normal";

            sortAndRenderArticles("DESC");
        });

        btnAsc.addEventListener("click", () => {
            btnAsc.style.fontWeight = "bold";
            btnDesc.style.fontWeight = "normal";

            sortAndRenderArticles("ASC");
        });
    }
}

function filterArticles(search: string): void {
    const filteredArticles = displayedArticles.filter((item) =>
        item.article.titre.toLowerCase().includes(search.toLowerCase())
    );

    renderArticles(filteredArticles);
}
init();
