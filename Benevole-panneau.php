<?php
require_once 'config/db.php';
session_start();

// Accès réservé admin / responsable
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

/* ===============================
   Filtres
================================ */
$ville_id = $_GET['ville'] ?? '';
$dispo = $_GET['disponibilite'] ?? '';
$age_min = $_GET['age_min'] ?? '';
$age_max = $_GET['age_max'] ?? '';
// Liste des disponibilités DISTINCT depuis la table Benevole
$disponibilites = $pdo
        ->query("SELECT DISTINCT disponibilite FROM Benevole WHERE disponibilite IS NOT NULL ORDER BY disponibilite ASC")
        ->fetchAll(PDO::FETCH_COLUMN);

/* ===============================
   Requête principale
================================ */
$sql = "
SELECT 
    b.*,
    v.nom AS ville_nom,
    TIMESTAMPDIFF(YEAR, b.date_naissance, CURDATE()) AS age,
    COUNT(mb.id_mission) AS nb_missions
FROM Benevole b
LEFT JOIN Ville v ON b.id_ville = v.id_ville
LEFT JOIN Mission_Benevole mb ON b.id_benevole = mb.id_benevole
WHERE 1=1
";

$params = [];

// Filtres dynamiques
if ($ville_id) {
    $sql .= " AND b.id_ville = ?";
    $params[] = $ville_id;
}

if ($dispo) {
    $sql .= " AND b.disponibilite = ?";
    $params[] = $dispo;
}

if ($age_min !== '') {
    $sql .= " AND TIMESTAMPDIFF(YEAR, b.date_naissance, CURDATE()) >= ?";
    $params[] = $age_min;
}

if ($age_max !== '') {
    $sql .= " AND TIMESTAMPDIFF(YEAR, b.date_naissance, CURDATE()) <= ?";
    $params[] = $age_max;
}

$sql .= " GROUP BY b.id_benevole ORDER BY b.nom ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$benevoles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Liste villes
$villes = $pdo->query("SELECT * FROM Ville ORDER BY nom ASC")->fetchAll();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion des Bénévoles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des adhérents & bénévoles</h2>
        <a href="form-benevole.php" class="btn btn-rose text-white">+ Nouveau bénévole</a>
    </div>

    <!-- FILTRES -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <div class="col-md-3">
                    <select name="ville" class="form-select">
                        <option value="">Toutes les villes</option>
                        <?php foreach ($villes as $v): ?>
                            <option value="<?= $v['id_ville'] ?>" <?= $ville_id == $v['id_ville'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($v['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="disponibilite" class="form-select">
                        <option value="">Toutes disponibilités</option>
                        <?php foreach ($disponibilites as $d): ?>
                            <option value="<?= htmlspecialchars($d) ?>" <?= $dispo === $d ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="number" name="age_min" class="form-control" placeholder="Âge min" value="<?= htmlspecialchars($age_min) ?>">
                </div>

                <div class="col-md-2">
                    <input type="number" name="age_max" class="form-control" placeholder="Âge max" value="<?= htmlspecialchars($age_max) ?>">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-outline-rose w-100">Filtrer</button>
                </div>

            </form>
        </div>
    </div>

    <!-- TABLEAU -->
    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover mb-0">
            <thead class="bg-rose text-white">
            <tr>
                <th>Bénévole</th>
                <th>Ville</th>
                <th>Âge</th>
                <th>Disponibilité</th>
                <th>Missions</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($benevoles as $b): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($b['prenom'].' '.$b['nom']) ?></strong><br>
                        <small><?= htmlspecialchars($b['email']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($b['ville_nom']) ?></td>
                    <td><?= $b['age'] ?> ans</td>
                    <td>
                        <span class="badge bg-light border">
                            <?= htmlspecialchars($b['disponibilite']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info-subtle border">
                            <?= $b['nb_missions'] ?> mission(s)
                        </span>
                    </td>
                    <td class="text-end">
                        <!-- NOUVEAUX BOUTONS -->
                        <a href="benevole-detail.php?id=<?= $b['id_benevole'] ?>" class="btn btn-sm btn-info">Détail</a>
                        <a href="benevole-missions.php?id=<?= $b['id_benevole'] ?>" class="btn btn-sm btn-warning text-white">Missions</a>
                        <!-- BOUTONS EXISTANTS -->
                        <a href="form-benevole.php?id=<?= $b['id_benevole'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <a href="supprimer.php?id=<?= $b['id_benevole'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce membre ?')">Supprimer</a>
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
