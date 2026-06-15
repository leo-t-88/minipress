import Handlebars from "handlebars";
import { ArticleList } from "./types";

export function renderArticles(articles: ArticleList["articles"]): void {
    const zone = document.getElementById("articles");
    if (!zone) return;

    const source = `
        {{#each articles}}
            <article>
                <h2>{{article.titre}}</h2>
                <p>Date : {{article.date_creation}}</p>
                <p>Id de l'Auteur : {{article.auteur_id}}</p>
            </article>
        {{/each}}
    `;

    const template = Handlebars.compile(source);
    zone.innerHTML = template({ articles });
}

export function renderCategories(categories: any[]): void {
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