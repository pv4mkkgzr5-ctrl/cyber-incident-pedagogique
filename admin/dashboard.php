<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';

// Sécurité : Seul l'admin peut accéder
if (!is_admin()) {
    redirect('../login.php');
}

// Récupération des incidents avec le nom de l'utilisateur (Jointure)
$stmt = $pdo->query("
    SELECT i.*, u.email 
    FROM incidents i
    JOIN users u ON i.user_id = u.id 
    ORDER BY i.created_at DESC
");
$incidents = $stmt->fetchAll();
?>

<div class="container">
    <h2><i class="fas fa-user-secret"></i> Dashboard Administrateur</h2>
    
    <div class="alert alert-info">
        Connecté en tant que : <strong><?= h($_SESSION['email']) ?></strong>
    </div>

    <div class="card" style="overflow-x: auto;">
        <h3 style="margin-bottom: 1rem;">Derniers Incidents Signalés</h3>
        
        <?php if (empty($incidents)): ?>
            <p>Aucun incident à traiter pour le moment.</p>
        <?php else: ?>
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                        <th style="padding: 1rem;">ID</th>
                        <th style="padding: 1rem;">Date</th>
                        <th style="padding: 1rem;">Type</th>
                        <th style="padding: 1rem;">Utilisateur</th>
                        <th style="padding: 1rem;">Statut</th>
                        <th style="padding: 1rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($incidents as $inc): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem;">#<?= h($inc['id']) ?></td>
                            <td style="padding: 1rem;"><?= h($inc['created_at']) ?></td>
                            <td style="padding: 1rem;">
                                <span style="background: rgba(0, 240, 255, 0.1); color: var(--accent-color); padding: 0.2rem 0.5rem; border-radius: 4px;">
                                    <?= h($inc['type_incident']) ?>
                                </span>
                            </td>
                            <td style="padding: 1rem;"><?= h($inc['email']) ?></td>
                            <td style="padding: 1rem;">
                                <?php 
                                    $statusColor = match($inc['status']) {
                                        'nouveau' => '#ff4d4d', // Rouge
                                        'en_cours' => '#ffca28', // Jaune
                                        'traite' => '#00e676', // Vert
                                        default => 'gray'
                                    };
                                ?>
                                <span style="color: <?= $statusColor ?>; font-weight: bold;">
                                    <?= h(ucfirst(str_replace('_', ' ', $inc['status']))) ?>
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <a href="view_incident.php?id=<?= $inc['id'] ?>" class="btn-login" style="font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Gérer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
