export function renderArticles(articles: any[]): void {
    const zone = document.getElementById("articles");
    if (!zone) return;

    zone.innerHTML = articles.map(item => `
        <article>
            <h2>${item.article.titre}</h2>
            <p>Date : ${item.article.date_creation}</p>
            <p>Id de l'Auteur : ${item.article.auteur_id}</p>
        </article>
    `).join("");
}
