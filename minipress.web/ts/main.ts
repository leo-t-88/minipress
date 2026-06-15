import { marked } from "marked";

async function loadArticle() {
    const res = await fetch("http://docketu.iutnc.univ-lorraine.fr:16797/api/articles/1");
    const json = await res.json();

    let md = json.article.contenu;

    md = md.replace(/\r\n/g, "\n");

    const html = marked.parse(md, { async: false });

    const container = document.getElementById("article");
    if (container) {
        container.innerHTML = html;
    }
}

loadArticle();

console.log("JS chargé");

