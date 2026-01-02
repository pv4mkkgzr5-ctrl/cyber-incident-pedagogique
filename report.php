<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

// Vérifier si l'utilisateur est connecté
if (!is_logged_in()) {
    redirect('login.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $type = $_POST['type'] ?? '';
    $description = $_POST['description'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Validation simple
    if (empty($type) || empty($description)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Traitement de l'upload (Facultatif)
        $filename = null;
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
            $max_size = 2 * 1024 * 1024; // 2 Mo

            $file_tmp = $_FILES['attachment']['tmp_name'];
            $file_name = $_FILES['attachment']['name'];
            $file_size = $_FILES['attachment']['size'];
            $file_type = mime_content_type($file_tmp);

            if (!in_array($file_type, $allowed_types)) {
                $error = "Type de fichier non autorisé (JPG, PNG, PDF uniquement).";
            } elseif ($file_size > $max_size) {
                $error = "Fichier trop volumineux (Max 2 Mo).";
            } else {
                // Génération d'un nom unique pour éviter les conflits et attaques
                $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                $filename = uniqid('incident_') . '.' . $extension;
                $destination = 'uploads/' . $filename;

                if (!move_uploaded_file($file_tmp, $destination)) {
                    $error = "Erreur lors de l'envoi du fichier.";
                }
            }
        }

        // Si pas d'erreur, insertion en base
        if (empty($error)) {
            $stmt = $pdo->prepare("INSERT INTO incidents (user_id, type_incident, description, created_at) VALUES (?, ?, ?, NOW())");
            if ($stmt->execute([$user_id, $type, $description])) {
                $success = "Signalement enregistré avec succès ! Un agent va le traiter.";
            } else {
                $error = "Erreur lors de l'enregistrement en base de données.";
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="container" style="max-width: 600px;">
    <h2><i class="fas fa-exclamation-triangle"></i> Signaler un Incident</h2>

    <?php if ($error): ?>
        <div class="alert" style="border-color: var(--danger-color); color: var(--danger-color);">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert" style="border-color: var(--success-color); color: var(--success-color);">
            <?= h($success) ?> <a href="index.php">Retour à l'accueil</a>
        </div>
    <?php endif; ?>

    <form method="POST" action="report.php" enctype="multipart/form-data" class="card">
        <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">

        <div style="margin-bottom: 1rem;">
            <label for="type">Type d'incident</label>
            <select id="type" name="type" required style="width: 100%; padding: 0.5rem; background: #0d1117; color: white; border: 1px solid #30363d;">
                <option value="">-- Sélectionner --</option>
                <option value="phishing">Phishing / Hameçonnage</option>
                <option value="ransomware">Ransomware (Rançonlogiciel)</option>
                <option value="piratage_compte">Piratage de compte</option>
                <option value="usurpation">Usurpation d'identité</option>
                <option value="autre">Autre</option>
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="description">Description détaillée</label>
            <textarea id="description" name="description" rows="5" required style="width: 100%; padding: 0.5rem; background: #0d1117; color: white; border: 1px solid #30363d;"></textarea>
            <small style="color: gray;">Soyez précis (dates, contexte, messages reçus).</small>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="attachment">Preuve (Capture d'écran / PDF) - Faculative</label>
            <input type="file" id="attachment" name="attachment" style="width: 100%; color: white;">
            <small style="color: gray;">Max 2 Mo. Formats : JPG, PNG, PDF.</small>
        </div>

        <button type="submit" class="btn-cta" style="width: 100%; border: none; cursor: pointer;">Envoyer le signalement</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
