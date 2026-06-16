import { getArticle, getArticles, getCategories } from "./api";
import { renderArticles, renderCategories, renderArticle } from "./view";
import { sortArticles, filterArticles, buildSearchable } from "./filters";
import { ArticleList } from "./types";

let displayedArticles: ArticleList["articles"] = [];
let searchableArticles: any[] = [];

async function loadCategories() {
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

            const path = (id === "all") ? "articles" : `categories/${id}/articles`

            await loadArticles(path);
        });
    } catch (error) {
        console.error(error);
        if (zoneCategories) zoneCategories.innerHTML = "<p>Erreur de chargement des catégories</p>";
    }
}

function setupSearch() {
    const searchInput = document.getElementById("search-input") as HTMLInputElement | null;
    if (!searchInput) return;

    searchInput.addEventListener("input", () => {
        const filtered = filterArticles(searchableArticles, searchInput.value);
        renderArticles(filtered);
        attachArticleListeners();
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
        attachArticleListeners();
    });

    btnAsc.addEventListener("click", () => {
        btnDesc.classList.remove("active");
        btnAsc.classList.add("active");

        displayedArticles = sortArticles(displayedArticles, "ASC");
        renderArticles(displayedArticles);
        attachArticleListeners();
    });
}

async function loadArticles(path: string) {
    const zoneArticles = document.getElementById("articles");
    if (zoneArticles) zoneArticles.innerHTML = "<p>Chargement...</p>";

    try {
        const response = await getArticles(path);

        displayedArticles = sortArticles(response.articles, "DESC");
        searchableArticles = await buildSearchable(displayedArticles);

        renderArticles(displayedArticles);
        attachArticleListeners();
    } catch (error) {
        console.error(error);
        if (zoneArticles) zoneArticles.innerHTML = "<p>Erreur de chargement</p>";
    }
}

function attachArticleListeners() {
    document.querySelectorAll(".article-item h2").forEach(item => {
        const href = item.getAttribute("data-href");
        if (!href) return;

        item.addEventListener("click", async () => {
            const article = await getArticle(href);
            renderArticle(article);
        });
    });

    document.querySelectorAll(".article-item p[data-id]").forEach(item => {
        const id = item.getAttribute("data-id");
        if (!id) return;

        item.addEventListener("click", async () => {
            await loadArticles(`auteurs/${id}/articles`);
        });
    });
}

async function init() {
    setupSearch();
    setupSorting();
    loadCategories();
    await loadArticles("articles");
}

init();
