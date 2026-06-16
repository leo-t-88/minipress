import { marked } from "marked";
import DOMPurify from "dompurify";
import Handlebars from "handlebars";

import { getArticle } from "./api";
import { Article, ArticleList, CategoryList } from "./types";

export function renderArticles(articles: ArticleList["articles"]): void {
    const zone = document.getElementById("articles");
    if (!zone) return;

    const source = `
        {{#each articles}}
            <article class="article-item">
                <h2 data-href="{{links.self.href}}">{{article.titre}}</h2>
                <p>Date : {{article.date_creation}}</p>
                <p>Auteur : {{article.auteur_id}}</p>
            </article>
        {{/each}}
    `;

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

    const source = `
        <ul>
            {{#each categories}}
                <li class="categorie-item" data-id="{{id}}">
                    {{nom}}
                </li>
            {{/each}}
        </ul>
    `;

    const template = Handlebars.compile(source);
    zone.innerHTML = template({ categories });
}

export async function showArticle(href: string): Promise<void> {
    const zone = document.getElementById("current_article");
    if (!zone) return;

    const json: Article = await getArticle(href);
    const a = json.article;

    const md = (txt: string) => DOMPurify.sanitize(marked.parse(txt.replace(/\r\n/g, "\n"), { async: false }));

    const source = `
        <article class="full-article">
            <h2>{{titre}}</h2>
            <p><strong>Publié le :</strong> {{date_publication}}</p>

            <div class="contenu">
                {{{contenu_html}}}
            </div>

            {{#if resume_html}}
            <div class="resume">
                <h3>Résumé</h3>
                {{{resume_html}}}
            </div>
            {{/if}}
        </article>
    `;

    const template = Handlebars.compile(source);

    const context = {
        titre: a.titre,
        date_publication: a.date_publication,
        resume_html: a.resume ? md(a.resume) : null,
        contenu_html: md(a.contenu)
    };

    zone.innerHTML = template(context);
}
