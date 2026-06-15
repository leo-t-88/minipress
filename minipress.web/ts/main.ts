import { getArticles } from "./api";
import { renderArticles } from "./view";
import { ArticleList } from "./types";

async function init(): Promise<void> {
    const zone = document.getElementById("articles");

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
        if (zone) zone.innerHTML = "<p>Erreur de chargement</p>";
    }
}

init();
