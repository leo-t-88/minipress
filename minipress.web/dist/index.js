"use strict";
(() => {
  // ts/config.ts
  var API_BASE_URL_TEST = "http://localhost/api";

  // ts/api.ts
  async function getArticles() {
    const response = await fetch(`${API_BASE_URL_TEST}/articles`);
    if (!response.ok) {
      throw new Error("Erreur lors du chargement des articles");
    }
    return response.json();
  }

  // ts/view.ts
  function renderArticles(articles) {
    const zone = document.getElementById("articles");
    if (!zone) return;
    zone.innerHTML = articles.map((item) => `
        <article>
            <h2>${item.article.titre}</h2>
            <p>Date : ${item.article.date_creation}</p>
            <p>Id de l'Auteur : ${item.article.auteur_id}</p>
        </article>
    `).join("");
  }

  // ts/main.ts
  async function init() {
    try {
      const response = await getArticles();
      const sortedArticles = response.articles.sort((a, b) => {
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
})();
