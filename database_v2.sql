-- MISE À JOUR V2 : LOGS & SÉCURITÉ
-- Copiez ce contenu et exécutez-le dans l'onglet SQL de phpMyAdmin

USE cyber_incident;

-- 1. Table des journaux d'activité (Logs)
CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL, -- NULL si l'action est faite par un inconnu (ex: tentative de login)
    action_type VARCHAR(50) NOT NULL, -- 'LOGIN_SUCCESS', 'LOGIN_FAIL', 'REPORT_CREATE', 'STATUS_CHANGE'
    details TEXT, -- Description (ex: "Nouvel incident #4 créé")
    ip_address VARCHAR(45) NOT NULL, -- IPv4 ou IPv6
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Table des tentatives de connexion (Anti-Brute Force)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
