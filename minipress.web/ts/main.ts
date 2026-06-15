import { getArticles } from "./api";
import { renderArticles } from "./view";

async function init(): Promise<void> {
    try {
        const response = await getArticles();

        const sortedArticles = response.articles.sort((a: any, b: any) => {
            return new Date(b.article.date_creation).getTime() - new Date(a.article.date_creation).getTime();
        });

        console.log(response);
        console.log(response.articles);
        console.log(response.articles.length);

        renderArticles(sortedArticles);
    } catch (error) {
        console.error(error);
    }
}

init();
