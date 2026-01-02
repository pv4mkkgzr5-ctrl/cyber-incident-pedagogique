<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Recherche de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie
        session_regenerate_id(true); // Protection contre la fixation de session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];

        // Redirection en fonction du rôle
        if ($user['role'] === 'admin') {
            redirect('admin/dashboard.php');
        } else {
            redirect('index.php');
        }
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}

require_once 'includes/header.php';
?>

<div class="container" style="max-width: 400px;">
    <h2><i class="fas fa-sign-in-alt"></i> Connexion</h2>

    <?php if ($error): ?>
        <div class="alert" style="border-color: var(--danger-color); color: var(--danger-color);">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="card">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

        <div style="margin-bottom: 1rem;">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required style="width: 100%; padding: 0.5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 0.5rem;">
        </div>

        <button type="submit" class="btn-cta" style="width: 100%; border: none; cursor: pointer;">Se connecter</button>
    </form>
    
    <p style="margin-top: 1rem; text-align: center;">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>
