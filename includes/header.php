<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYBER-INCIDENT - Signalement Sécurisé</title>
    <!-- Utilisation de chemins absolus pour fonctionner depuis /admin/ aussi -->
    <link rel="stylesheet" href="/cyber-incident/assets/css/style.css">
    <!-- Font Awesome pour les icônes (via CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <i class="fas fa-shield-alt"></i> CYBER-INCIDENT
        </div>
        <ul class="nav-links">
            <li><a href="/cyber-incident/index.php">Accueil</a></li>
            <?php if (is_logged_in()): ?>
                <li><a href="/cyber-incident/report.php">Signaler un incident</a></li>
                <?php if (is_admin()): ?>
                    <li><a href="/cyber-incident/admin/dashboard.php">Administration</a></li>
                <?php endif; ?>
                <li><a href="/cyber-incident/logout.php" class="btn-login">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="/cyber-incident/register.php">Inscription</a></li>
                <li><a href="/cyber-incident/login.php" class="btn-login">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
