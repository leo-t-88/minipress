import { marked } from "marked";
import DOMPurify from "dompurify";
import Handlebars from "handlebars";

import { getArticle } from "./api";
import { Article, ArticleList, CategoryList } from "./types";

export function renderArticles(articles: ArticleList["articles"]): void {
    const zone = document.getElementById("articles");
    if (!zone) return;

    const source = (document.getElementById("tpl-articles") as HTMLScriptElement).innerHTML;
    const template = Handlebars.compile(source);
    zone.innerHTML = template({ articles });

    document.querySelectorAll(".article-item > h2").forEach(item => {
        const href = item.getAttribute("data-href");
        if (!href) return;

        item.addEventListener("click", () => {
            showArticle(href);
        });
    });
}

export function renderCategories(categories: CategoryList["categories"]): void {
    const zone = document.getElementById("categories-list");
    if (!zone) return;

    const source = (document.getElementById("tpl-categories") as HTMLScriptElement).innerHTML;
    const template = Handlebars.compile(source);
    zone.innerHTML = template({ categories });
}

export async function showArticle(href: string): Promise<void> {
    const zone = document.getElementById("current_article");
    if (!zone) return;

    const json: Article = await getArticle(href);
    const a = json.article;

    const md = (txt: string) => DOMPurify.sanitize(marked.parse(txt.replace(/\r\n/g, "\n"), { async: false }));

    const source = (document.getElementById("tpl-full-article") as HTMLScriptElement).innerHTML;
    const template = Handlebars.compile(source);

    const context = {
        titre: a.titre,
        date_publication: a.date_publication,
        resume_html: a.resume ? md(a.resume) : null,
        contenu_html: md(a.contenu)
    };

    zone.innerHTML = template(context);
}
