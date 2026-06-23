CREATE DATABASE IF NOT EXISTS classroom;
USE classroom;

CREATE DATABASE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'professeur', 'etudiant') NOT NULL DEFAULT 'etudiant',
    actif TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    classe_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_inscription (etudiant_id, classe_id),
    FOREIGN KEY (etudiant_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (classe_id) REFERENCES classes(id) ON DELETE CASCADE
);

CREATE TABLE cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(200) NOT NULL,
    description TEXT,
    fichier VARCHAR(255),
    classe_id INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (classe_id) REFERENCES classes(id) ON DELETE CASCADE
);

CREATE TABLE devoirs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(200) NOT NULL,
    consigne TEXT NOT NULL,
    date_limite DATETIME NOT NULL,
    classe_id INT NOT NULL,
    created_at DATABASE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATABASE NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (classe_id) REFERENCES classes(id) ON DELETE CASCADE
);

CREATE TABLE rendus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    devoir_id INT NOT NULL,
    etudiant_id INT NOT NULL,
    fichier VARCHAR(255),
    commentaire TEXT,
    note DECIMAL(4, 2),
    correction TEXT,
    rendu_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_rendu (devoir_id, etudiant_id),
    FOREIGN KEY (devoir_id) REFERENCES devoirs(id) ON DELETE CASCADE,
    FOREIGN KEY (etudiant_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    expediteur_id   INT NOT NULL,
    destinataire_id INT NOT NULL,
    sujet           VARCHAR(200),
    contenu         TEXT NOT NULL,
    lu              TINYINT(1) NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (expediteur_id)   REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (destinataire_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notifications (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,
    message     VARCHAR(500) NOT NULL,
    lu          TINYINT(1) NOT NULL DEFAULT 0,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

// TEST 
INSERT INTO users (nom, prenom, email, password, role) VALUES
('Admin',  'Système', 'admin@classroom.local',    'admin123', 'admin'),
('Dupont', 'Marie',   'prof@classroom.local',     'professeur123', 'professeur'),
('Martin', 'Lucas',   'etudiant@classroom.local', 'etudiant123', 'etudiant');
 