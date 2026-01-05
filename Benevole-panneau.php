<?php
require_once 'config/db.php';
session_start();

// Protection de l'accès (Seulement admin/responsable)
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

// Récupération des filtres depuis l'URL
$ville_id = $_GET['ville'] ?? '';
$statut = $_GET['statut'] ?? '';

// Construction de la requête SQL avec jointures pour les villes
$sql = "SELECT b.*, v.nom AS ville_nom 
        FROM Benevole b 
        LEFT JOIN Ville v ON b.id_ville = v.id_ville 
        WHERE 1=1";

$params = [];
if ($ville_id) {
    $sql .= " AND b.id_ville = ?";
    $params[] = $ville_id;
}
if ($statut) {
    $sql .= " AND b.statut = ?";
    $params[] = $statut;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$benevoles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion Bénévoles — Les Blouses Roses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>
<main id="contenu" class="container my-5">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-people text-rose"></i> Gestion des Adhérents</h2>
            <a href="form-benevole.php" class="btn btn-rose text-white">+ Nouveau Bénévole</a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <select name="ville" class="form-select">
                            <option value="">Toutes les villes</option>
                            <?php
                            $villes = $pdo->query("SELECT * FROM Ville ORDER BY nom ASC")->fetchAll();
                            foreach($villes as $v) {
                                $selected = ($ville_id == $v['id_ville']) ? 'selected' : '';
                                echo "<option value='{$v['id_ville']}' $selected>{$v['nom']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="statut" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="Actif" <?= $statut == 'Actif' ? 'selected' : '' ?>>Actif</option>
                            <option value="Inactif" <?= $statut == 'Inactif' ? 'selected' : '' ?>>Inactif</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-rose w-100">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive shadow-sm rounded bg-white">
            <table class="table table-hover mb-0">
                <thead class="bg-rose text-white">
                <tr>
                    <th>Bénévole</th>
                    <th>Ville</th>
                    <th>Disponibilité</th>
                    <th>Cotisation</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($benevoles as $b): ?>
                    <tr>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars($b['nom'] . ' ' . $b['prenom']) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($b['email']) ?></small>
                        </td>
                        <td><?= htmlspecialchars($b['ville_nom']) ?></td>
                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($b['disponibilite']) ?></span></td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success">À jour</span>
                        </td>
                        <td class="text-end">
                            <a href="form-benevole.php?id=<?= $b['id_benevole'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <a href="supprimer.php?id=<?= $b['id_benevole'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce membre ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="footer-container"></div>

<!-- ================= JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
<script src="js/interne.js"></script>



</body>
</html>