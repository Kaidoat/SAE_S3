<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$planning = $pdo->query("
    SELECT 'Mission' AS type, titre AS nom, date_debut AS date FROM Mission
    UNION
    SELECT 'Événement', nom, date_event FROM Evenement
    ORDER BY date ASC
")->fetchAll();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Calendrier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">
    <h2 class="mb-4">Calendrier global</h2>

    <table class="table bg-white shadow-sm">
        <thead class="bg-rose text-white">
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Nom</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($planning as $p): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($p['date'])) ?></td>
                <td><?= $p['type'] ?></td>
                <td><?= htmlspecialchars($p['nom']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>

<div id="footer-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
