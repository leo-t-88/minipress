// filters.ts
import { ArticleList } from "./types";
import { getArticle } from "./api";

export function sortArticles(
    articles: ArticleList["articles"],
    order: "ASC" | "DESC"
) {
    return [...articles].sort((a, b) => {
        const tA = new Date(a.article.date_creation).getTime();
        const tB = new Date(b.article.date_creation).getTime();
        return order === "DESC" ? tB - tA : tA - tB;
    });
}

export function filterArticles(searchable: any[], search: string) {
    const value = search.toLowerCase();
    return searchable.filter((item) =>
        item.article.titre.toLowerCase().includes(value) ||
        item.resume.toLowerCase().includes(value)
    );
}

export async function buildSearchable(articles: ArticleList["articles"]) {
    return Promise.all(
        articles.map(async (item) => {
            const full = await getArticle(item.links.self.href);
            return {
                ...item,
                resume: full.article.resume || ""
            };
        })
    );
}
