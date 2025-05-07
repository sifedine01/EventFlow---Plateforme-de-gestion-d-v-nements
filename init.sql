CREATE DATABASE evenements;
USE evenements;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    description TEXT,
    date_event DATE,
    lieu VARCHAR(255),
    statut ENUM('en_attente', 'valide', 'refuse') DEFAULT 'en_attente',
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);

INSERT INTO utilisateurs (nom, email, mot_de_passe, role)
VALUES ('admin', 'admin@demo.com', '$2y$10$Bhm06AJ/JGZmvNOhLMkzleGp8COyK8rRX2HbxGbHbZcZwDyQ1U8Ky', 'admin');