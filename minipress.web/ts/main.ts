
import { getArticles } from "./api";
import { renderArticles } from "./view";

async function init(): Promise<void> {
    const zone = document.getElementById("articles");

    try {
        const response = await getArticles();

        const sortedArticles = response.articles.sort((a: any, b: any) => {
            return new Date(b.article.date_creation).getTime() - new Date(a.article.date_creation).getTime();
        });

        renderArticles(sortedArticles);
    } catch (error) {
        console.error(error);
        if (zone) zone.innerHTML = "<p>Erreur de chargement</p>";
    }
}

init();
