import { marked } from "marked";
import DOMPurify from "dompurify";
import Handlebars from "handlebars";

import { Article, ArticleList, CategoryList } from "./types";

export function renderArticles(articles: ArticleList["articles"]): void {
    const zone = document.getElementById("articles");
    if (!zone) return;

    const source = (document.getElementById("tpl-articles") as HTMLScriptElement).innerHTML;
    const template = Handlebars.compile(source);
    zone.innerHTML = template({ articles });
}

export function renderCategories(categories: CategoryList["categories"]): void {
    const zone = document.getElementById("categories-list");
    if (!zone) return;

    const source = (document.getElementById("tpl-categories") as HTMLScriptElement).innerHTML;
    const template = Handlebars.compile(source);
    zone.innerHTML = template({ categories });
}

export function renderArticle(a: Article): void {
    const zone = document.getElementById("current_article");
    if (!zone) return;

    const md = (txt: string) => DOMPurify.sanitize(marked.parse(txt.replace(/\r\n/g, "\n"), { async: false }));

    const source = (document.getElementById("tpl-full-article") as HTMLScriptElement).innerHTML;
    const template = Handlebars.compile(source);

    const context = {
        titre: a.article.titre,
        date_publication: a.article.date_publication,
        resume_html: a.article.resume ? md(a.article.resume) : null,
        contenu_html: md(a.article.contenu)
    };

    zone.innerHTML = template(context);
}