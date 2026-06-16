import { getArticles, getCategories, getArticlesByCategorie } from "./api";
import { renderArticles, renderCategories } from "./view";
import { sortArticles, filterArticles, buildSearchable } from "./filters";
import { ArticleList } from "./types";

let displayedArticles: ArticleList["articles"] = [];
let searchableArticles: any[] = [];

async function loadInitialArticles() {
    const zoneArticles = document.getElementById("articles");

    try {
        const response: ArticleList = await getArticles();

        displayedArticles = sortArticles(response.articles, "DESC");
        searchableArticles = await buildSearchable(displayedArticles);

        renderArticles(displayedArticles);
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }
}

async function setupCategories() {
    const zoneCategories = document.getElementById("categories-list");

    try {
        const response = await getCategories();
        renderCategories(response.categories);

        zoneCategories?.addEventListener("click", async (event) => {
            const target = event.target as HTMLElement;
            const item = target.closest(".categorie-item") as HTMLElement | null;
            if (!item) return;

            const id = item.dataset.id;
            if (!id) return;

            await loadCategory(id);
        });
    } catch (error) {
        console.error(error);
        if (zoneCategories) zoneCategories.innerHTML = "<p>Erreur de chargement des catégories</p>";
    }
}

async function loadCategory(id: string) {
    const zoneArticles = document.getElementById("articles");
    if (zoneArticles) zoneArticles.innerHTML = "<p>Chargement...</p>";

    try {
        const response = id === "all" ? await getArticles() : await getArticlesByCategorie(id);

        displayedArticles = sortArticles(response.articles, "DESC");
        searchableArticles = await buildSearchable(displayedArticles);

        renderArticles(displayedArticles);
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }
}

function setupSearch() {
    const searchInput = document.getElementById("search-input") as HTMLInputElement | null;
    if (!searchInput) return;

    searchInput.addEventListener("input", () => {
        const filtered = filterArticles(searchableArticles, searchInput.value);
        renderArticles(filtered);
    });
}

function setupSorting() {
    const btnDesc = document.getElementById("btn-sort-desc");
    const btnAsc = document.getElementById("btn-sort-asc");

    if (!btnDesc || !btnAsc) return;

    btnDesc.addEventListener("click", () => {
        btnAsc.classList.remove("active");
        btnDesc.classList.add("active");

        displayedArticles = sortArticles(displayedArticles, "DESC");
        renderArticles(displayedArticles);
    });

    btnAsc.addEventListener("click", () => {
        btnDesc.classList.remove("active");
        btnAsc.classList.add("active");

        displayedArticles = sortArticles(displayedArticles, "ASC");
        renderArticles(displayedArticles);
    });
}

async function init() {
    setupSearch();
    setupSorting();
    setupCategories();
    await loadInitialArticles();
}

init();
