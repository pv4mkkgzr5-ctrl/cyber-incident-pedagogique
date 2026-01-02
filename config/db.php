<?php
// config/db.php
// Configuration de la connexion à la base de données

// Paramètres de connexion
$host = 'localhost';
$dbname = 'cyber_incident';
$username = 'root'; // Par défaut sous XAMPP
$password = '';     // Par défaut vide sous XAMPP

try {
    // Création de l'objet PDO avec gestion d'erreur stricte
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configuration des options PDO pour la sécurité et le debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Lève une exception en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retourne des tableaux associatifs
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Utilise les vraies requêtes préparées (sécurité)

} catch (PDOException $e) {
    // En cas d'erreur de connexion, on arrête tout et on affiche un message (pas le détail technique en prod)
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

