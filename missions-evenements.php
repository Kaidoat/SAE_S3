<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

/* ================= MISSIONS ================= */
$missions = $pdo->query("
    SELECT 
        m.*,
        COUNT(mb.id_benevole) AS nb_benevoles
    FROM Mission m
    LEFT JOIN Mission_Benevole mb ON m.id_mission = mb.id_mission
    GROUP BY m.id_mission
    ORDER BY m.date_debut DESC
")->fetchAll(PDO::FETCH_ASSOC);

/* ================= EVENEMENTS ================= */
$evenements = $pdo->query("
    SELECT 
        e.*,
        COUNT(eb.id_benevole) AS nb_benevoles
    FROM Evenement e
    LEFT JOIN Evenement_Benevole eb ON e.id_evenement = eb.id_evenement
    GROUP BY e.id_evenement
    ORDER BY e.date_event DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Missions & Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
<div id="navbar-container"></div>

<main class="container my-5">

    <h2 class="mb-4">Gestion des missions et événements</h2>

    <!-- ================= MISSIONS ================= -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Missions</h4>
        <a href="form-mission.php" class="btn btn-rose text-white">+ Nouvelle mission</a>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded mb-5">
        <table class="table table-hover">
            <thead class="bg-rose text-white">
            <tr>
                <th>Titre</th>
                <th>Période</th>
                <th>Type</th>
                <th>Bénévoles</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($missions as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['titre']) ?></td>
                    <td><?= $m['date_debut'] ?> → <?= $m['date_fin'] ?></td>
                    <td><?= htmlspecialchars($m['type_mission']) ?></td>
                    <td><?= $m['nb_benevoles'] ?></td>
                    <td class="text-end">
                        <a href="mission-detail.php?id=<?= $m['id_mission'] ?>" class="btn btn-sm btn-info">Détails</a>
                        <a href="form-mission.php?id=<?= $m['id_mission'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <a href="supprimer-mission.php?id=<?= $m['id_mission'] ?>" class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Supprimer cette mission ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- ================= EVENEMENTS ================= -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4>Événements</h4>
        <a href="form-evenement.php" class="btn btn-rose text-white">+ Nouvel événement</a>
    </div>

    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover">
            <thead class="bg-rose text-white">
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Type</th>
                <th>Bénévoles</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($evenements as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['nom']) ?></td>
                    <td><?= $e['date_event'] ?></td>
                    <td><?= htmlspecialchars($e['type_evenement']) ?></td>
                    <td><?= $e['nb_benevoles'] ?></td>
                    <td class="text-end">
                        <a href="evenement-detail.php?id=<?= $e['id_evenement'] ?>" class="btn btn-sm btn-info">Détails</a>
                        <a href="form-evenement.php?id=<?= $e['id_evenement'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <a href="supprimer-evenement.php?id=<?= $e['id_evenement'] ?>" class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Supprimer cet événement ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<div id="footer-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
