# MiniPress
- Muhammet BAYRAM
- Loïc DURAND
- Johan SCHAEFFER
- Léo THOMAS
S4DWM1

### Ressources
Dépot Git : https://github.com/leo-t-88/minipress
URL Docketu (Panel) : http://docketu.iutnc.univ-lorraine.fr:16797/
URL Docketu (User) : http://docketu.iutnc.univ-lorraine.fr:16798/

### Installation
- Copiez coller le fichier ``.database_env.dist`` en ``.database_env`` et remplir le fichier
- Fait de même pour ``gift.appli/src/conf/gift.db.conf.ini.dist`` en ``gift.appli/src/conf/gift.db.conf.ini``
- Executer les requètes SQL des fichiers ``sql/minipress.sql`` puis ``sql/minipress_data.sql`` dans adminer (http://localhost:8080 par defaut)
- Une fois les fichiers complété avec la bonne configuration
- Lancer docker (s'il n'est pas déjà lancé) puis ouvrez un terminal dans le repertoire racine du projet giftbox et excecutez la commande suivante : ``docker compose up``
- Accedez à l'appli via http://localhost:80 et http://localhost:81

### Fonctionnalité réalisées
- Muhammet :
    - Backend (Panel Admin)
        - 1 (Créer un article : affichage et traitement d’un formulaire de saisie d’un article)
        - 3 (Afficher la liste des articles : affichage de la liste des articles sur le CMS)
        - 10 (Api : liste des articles disponible au format JSON sur l’url /api/articles)
        - 11 (Api : articles d’une catégorie disponible sur l’url /api/categories/{id_categ}/articles.)
        - 16 (Tri de la liste d’articles dans l’api)
    - Frontend (Site static)
        - 5 (Affichage liste articles d'un auteur en cliquant sur son nom)
    - Appli Mobile
        - 5 (Affichage liste articles d'un auteur en cliquant sur son nom)
- Loïc :
    - Backend (Panel Admin)
        - 1 (Créer un article : affichage et traitement d’un formulaire de saisie d’un article)
        - 2 (Créer un article en choisissant une catégorie)
        - 3 (Afficher la liste des articles : affichage de la liste des articles sur le CMS)
        - 4 (Afficher la liste des articles en filtrant par catégorie)
        - 13 (Api : liste des articles d’un auteur disponible à l’url /api/auteurs/{id}/articles)
    - Frontend (Site static)
        - 2 (Affichage complet d’un article en cliquant sur un article dans une liste)
        - 6 (Tri des listes d’articles selon l’ordre ascendant ou descendant de la date de création)
    - Appli Mobile
        - 7 (Filtrage des listes d’articles selon un mot clé dans le titre)
        - 8 (Filtrage des listes d’articles selon un mot clé dans le titre ou dans le résumé)
- Johan :
    - Backend (Panel Admin)
        - 5 (Création d’une catégorie)
        - 6 (Formulaire d’authentification)
        - 9 (Api : liste des catégories disponible au format JSON sur l’url /api/categories)
        - 12 (Api : article complet disponible au format JSON à l’url /api/articles/{id_a})
        - 15 (Création d’utilisateurs)
    - Frontend (Site static)
        - 1 (Affichage de la liste des articles dans l’ordre chronologique inverse)
        - 3 (Affichage de la liste des articles d’une catégorie, en cliquant sur la catégorie)
        - 7 (Filtrage des listes d’articles selon un mot clé dans le titre)
        - 8 (Filtrage des listes d’articles selon un mot clé dans le titre ou dans le résumé)
    - Appli Mobile
        - 2 (Affichage complet d’un article en cliquant sur un article dans une liste)
        - 3 (Affichage de la liste des articles d’une catégorie, en cliquant sur la catégorie)
- Léo :
    - Backend (Panel Admin)
        - 7 (Contrôle d’accès)
        - 8 (Auteurs : affichage de l'auteur de chaque article dans la liste d'article)
        - 14 (Publication/dépublication des articles)
        - 15 (Création d’utilisateurs)
        - 16 (Tri de la liste d’articles dans l’api)
    - Frontend (Site static)
        - 1 (Affichage de la liste des articles dans l’ordre chronologique inverse)
        - 4 (Affichage complet d’un article en cliquant sur un article dans une liste)
        - 5 (Affichage liste articles d'un auteur en cliquant sur son nom)
    - Appli Mobile
        - 1 (Affichage de la liste des articles dans l’ordre chronologique inverse)
        - 4 (Affichage complet d’un article en cliquant sur un article dans une liste)
        - 6 (Tri des listes d’articles selon l’ordre ascendant ou descendant de la date de création)

### Info permisions utilisateurs connectés
| Permission | **Auteur (>= 1 && < 50)** | **Admin (>= 50 && < 100)** | **SuperAdmin (100)** |
|-----------|-------------------------------|----------------------------------|-------------------------------------------|
| **Comptes pour tester** | Mail `loic@gmail.com`, mdp `Loic1234` | Mail `hi@gmail.com`, mdp `Malik1234`<br>Mail `johan@gmail.com`, mdp `Johan1234` | Mail `leo.thomas@minipress.com`, mdp `Utilisateur1` |
| **Créer un article** | ✔️ | ✔️ | ✔️ |
| **Créer une catégorie** | ✔️ | ✔️ | ✔️ |
| **Voir les articles** | ✔️ | ✔️ | ✔️ |
| **Publier/dépublier des articles** | Uniquement les siens | Tous | Tous |
| **Créer des comptes utilisateurs** | ❌ | ❌ | ✔️ |