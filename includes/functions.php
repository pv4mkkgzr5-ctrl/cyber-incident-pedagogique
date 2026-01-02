<?php
// includes/functions.php
// Fonctions utilitaires pour la sécurité et l'affichage

// Démarrage de la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    // Sécurisation du cookie de session
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => false, // Mettre à true si HTTPS
        'httponly' => true, // Empêche l'accès JS au cookie (Protection XSS)
        'samesite' => 'Strict'
    ]);
    session_start();
}

// Security Headers (Durcissement)
header("X-Frame-Options: DENY"); // Empêche d'être intégré dans une iframe
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");

/**
 * Enregistre une action dans les logs (Traçabilité)
 */
function log_action($pdo, $action_type, $details = '', $user_id = null) {
    // Si l'utilisateur est connecté et $user_id n'est pas fourni, on prend celui de la session
    if ($user_id === null && isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    }
    
    $ip = $_SERVER['REMOTE_ADDR'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO logs (user_id, action_type, details, ip_address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $action_type, $details, $ip]);
    } catch (Exception $e) {
        // En cas d'erreur de log, on continue quand même (fail-open pour ne pas bloquer l'usage)
        // Mais idéalement on devrait alerter l'admin.
    }
}

/**
 * Protection XSS (Cross-Site Scripting)
 * Échappe les caractères spéciaux HTML
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Vérifie si l'utilisateur est admin
 */
function is_admin() {
    return is_logged_in() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Redirection simple
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Génère un token CSRF et le stocke en session
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie le token CSRF reçu en POST
 */
function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : Token CSRF invalide.");
    }
    return true;
}

