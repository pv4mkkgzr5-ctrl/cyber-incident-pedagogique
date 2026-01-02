-- CRÉATION DE LA BASE DE DONNÉES
CREATE DATABASE IF NOT EXISTS cyber_incident CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cyber_incident;

-- TABLE UTILISATEURS
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Stockage du Hash (bcrypt)
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- TABLE INCIDENTS
CREATE TABLE IF NOT EXISTS incidents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type_incident VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    status ENUM('nouveau', 'en_cours', 'traite') DEFAULT 'nouveau',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- DONNÉES DE TEST (Mots de passe : "Password123!")
-- Le hash doit être généré via PHP `password_hash('Password123!', PASSWORD_BCRYPT)`
-- Voici un hash d'exemple pour "Password123!"
INSERT INTO users (email, password, role) VALUES 
('admin@cyber-police.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('user@citoyen.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');
