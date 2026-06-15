import Handlebars from "handlebars";

export function renderArticles(articles: any[]): void {
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
