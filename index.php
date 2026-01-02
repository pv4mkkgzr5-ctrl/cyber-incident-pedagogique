<?php require_once 'includes/header.php'; ?>

<section class="hero">
    <h1>Plateforme de Signalement Cyber</h1>
    <p>Signalez les incidents de sécurité informatique (Phishing, Ransomware, Usurpation) sur notre plateforme sécurisée et pédagogique.</p>
    
    <?php if (is_logged_in()): ?>
        <a href="report.php" class="btn-cta"><i class="fas fa-exclamation-triangle"></i> Signaler un incident</a>
    <?php else: ?>
        <a href="login.php" class="btn-cta">Connexion / Inscription</a>
    <?php endif; ?>
</section>

<div class="container">
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> <strong>Projet Pédagogique :</strong> Cette plateforme a été développée pour démontrer des compétences en développement web sécurisé (OWASP Top 10).
    </div>

    <div class="features">
        <div class="card">
            <h3><i class="fas fa-user-shield"></i> Signalement Simple</h3>
            <p>Décrivez l'incident, ajoutez des preuves (captures d'écrans sécurisées) et suivez l'avancement.</p>
        </div>
        <div class="card">
            <h3><i class="fas fa-lock"></i> Sécurité Maximale</h3>
            <p>Vos données sont protégées. Mots de passe chiffrés, protection contre les injections SQL et failles XSS.</p>
        </div>
        <div class="card">
            <h3><i class="fas fa-tasks"></i> Suivi Administratif</h3>
            <p>Les agents peuvent traiter les incidents, changer les statuts et analyser les menaces en temps réel.</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
