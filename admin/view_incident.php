<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Sécurité : Seul l'admin
if (!is_admin()) {
    redirect('../login.php');
}

$id = $_GET['id'] ?? null;
if (!$id) {
    redirect('dashboard.php');
}

// Traitement de la mise à jour du statut
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    $new_status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE incidents SET status = ? WHERE id = ?");
    if ($stmt->execute([$new_status, $id])) {
        $message = "Statut mis à jour avec succès.";
    }
}

// Récupération de l'incident
$stmt = $pdo->prepare("
    SELECT i.*, u.email 
    FROM incidents i
    JOIN users u ON i.user_id = u.id 
    WHERE i.id = ?
");
$stmt->execute([$id]);
$incident = $stmt->fetch();

if (!$incident) {
    die("Incident introuvable.");
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <a href="dashboard.php" style="display: inline-block; margin-bottom: 1rem;">&larr; Retour au tableau de bord</a>
    
    <h2>Détail de l'incident #<?= h($incident['id']) ?></h2>

    <?php if ($message): ?>
        <div class="alert" style="border-color: var(--success-color); color: var(--success-color);">
            <?= h($message) ?>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        
        <!-- Colonne Gauche : Infos -->
        <div class="card">
            <h3 style="color: var(--accent-color); margin-bottom: 1rem;">Informations</h3>
            
            <p><strong>Date :</strong> <?= h($incident['created_at']) ?></p>
            <p><strong>Signalé par :</strong> <?= h($incident['email']) ?></p>
            <p><strong>Type :</strong> <?= h($incident['type_incident']) ?></p>
            
            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 1.5rem 0;">
            
            <h4>Description</h4>
            <div style="background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 4px; margin-top: 0.5rem; white-space: pre-wrap;">
                <?= h($incident['description']) ?>
            </div>

            <!-- Affichage pièce jointe si elle existe (logique fictive car pas stockée en base dans report.php initial, 
                 mais le fichier est uploadé. Pour l'exercice on affiche juste un lien si on le trouve via le code d'upload 
                 ou on laisse vide si non implémenté en BDD full) -->
             <?php
                // Note : Pour l'exercice pédagogique, j'ai simplifié l'upload sans colonne 'filename' en BDD dans report.php. 
                // Pour une V2, il faudrait ajouter la colonne 'attachment' dans la table incidents.
             ?>
        </div>

        <!-- Colonne Droite : Action -->
        <div class="card" style="height: fit-content;">
            <h3 style="color: var(--accent-color); margin-bottom: 1rem;">Traitement</h3>
            
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
                
                <label for="status">Changer le statut :</label>
                <select name="status" id="status" style="width: 100%; padding: 0.5rem; margin: 0.5rem 0 1rem; background: #0d1117; color: white; border: 1px solid #30363d;">
                    <option value="nouveau" <?= $incident['status'] == 'nouveau' ? 'selected' : '' ?>>Nouveau</option>
                    <option value="en_cours" <?= $incident['status'] == 'en_cours' ? 'selected' : '' ?>>En cours d'analyse</option>
                    <option value="traite" <?= $incident['status'] == 'traite' ? 'selected' : '' ?>>Traité / Clôturé</option>
                </select>

                <button type="submit" class="btn-cta" style="width: 100%; border: none; cursor: pointer;">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
