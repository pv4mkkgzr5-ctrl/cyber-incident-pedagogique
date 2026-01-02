<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Vérification CSRF
    verify_csrf_token($_POST['csrf_token'] ?? '');

    // 2. Récupération et nettoyage des entrées
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // 3. Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit faire au moins 8 caractères.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // 4. Vérification si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // 5. Hashage du mot de passe
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // 6. Insertion en base
            $insert = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            if ($insert->execute([$email, $hash])) {
                $success = "Compte créé avec succès ! Vous pouvez vous connecter.";
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container" style="max-width: 500px;">
    <h2><i class="fas fa-user-plus"></i> Inscription</h2>
    
    <?php if ($error): ?>
        <div class="alert" style="border-color: var(--danger-color); color: var(--danger-color);">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert" style="border-color: var(--success-color); color: var(--success-color);">
            <?= h($success) ?> <a href="login.php">Se connecter</a>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php" class="card">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
        
        <div style="margin-bottom: 1rem;">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" name="email" required style="width: 100%; padding: 0.5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password">Mot de passe (8 car. min)</label>
            <input type="password" id="password" name="password" required minlength="8" style="width: 100%; padding: 0.5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 0.5rem;">
        </div>

        <button type="submit" class="btn-cta" style="width: 100%; border: none; cursor: pointer;">S'inscrire</button>
    </form>
    
    <p style="margin-top: 1rem; text-align: center;">Déjà un compte ? <a href="login.php">Se connecter</a></p>
</div>

<?php require_once 'includes/footer.php'; ?>
