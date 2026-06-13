-- Création de la base de données
CREATE DATABASE IF NOT EXISTS minipress
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE minipress;

CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role INT NOT NULL
);

CREATE TABLE Categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE Article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    resume TEXT NULL,
    contenu TEXT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_publication DATETIME NULL,
    auteur_id INT NOT NULL,
    categorie_id INT NULL,

    CONSTRAINT fk_article_auteur
        FOREIGN KEY (auteur_id)
        REFERENCES user(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,

    CONSTRAINT fk_article_categorie
        FOREIGN KEY (categorie_id)
        REFERENCES categorie(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);