<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: espace-interne.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: panneau-mission-evenement.php');
    exit;
}

// Récupérer la mission
$stmt = $pdo->prepare("SELECT * FROM Mission WHERE id_mission = ?");
$stmt->execute([$id]);
$mission = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$mission) {
    header('Location: panneau-mission-evenement.php');
    exit;
}

/* ===== BENEVOLES ===== */
$benevoles = $pdo->prepare("
    SELECT b.prenom, b.nom
    FROM Mission_Benevole mb
    JOIN Benevole b ON mb.id_benevole = b.id_benevole
    WHERE mb.id_mission = ?
");
$benevoles->execute([$id]);
$benevoles = $benevoles->fetchAll();


// Récupérer le matériel déjà associé
$materiel_associe = $pdo->prepare("
    SELECT mm.id_mat, m.nom_materiel, mm.quantite
    FROM Mission_Materiel mm
    JOIN Materiel m ON mm.id_mat = m.id_mat
    WHERE mm.id_mission = ?
");
$materiel_associe->execute([$id]);
$materiel_associe = $materiel_associe->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tout le matériel disponible
$materiel_disponible = $pdo->query("SELECT * FROM Materiel ORDER BY nom_materiel ASC")->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire d'ajout de matériel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_mat'], $_POST['quantite'])) {
    $id_mat = $_POST['id_mat'];
    $quantite = (int)$_POST['quantite'];

    // Vérifier si le matériel est déjà associé
    $check = $pdo->prepare("SELECT * FROM Mission_Materiel WHERE id_mission = ? AND id_mat = ?");
    $check->execute([$id, $id_mat]);
    if ($check->rowCount() > 0) {
        // Mise à jour de la quantité
        $pdo->prepare("UPDATE Mission_Materiel SET quantite = ? WHERE id_mission = ? AND id_mat = ?")
            ->execute([$quantite, $id, $id_mat]);
    } else {
        // Ajout de la nouvelle association
        $pdo->prepare("INSERT INTO Mission_Materiel (id_mission, id_mat, quantite) VALUES (?, ?, ?)")
            ->execute([$id, $id_mat, $quantite]);
    }

    header("Location: mission-detail.php?id=$id");
    exit;
}

// Suppression du matériel
if (isset($_GET['delete_mat'])) {
    $delete_id = $_GET['delete_mat'];
    $pdo->prepare("DELETE FROM Mission_Materiel WHERE id_mission = ? AND id_mat = ?")
        ->execute([$id, $delete_id]);
    header("Location: mission-detail.php?id=$id");
    exit;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Détails Mission — <?= htmlspecialchars($mission['titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">
    <h2>Détails de la mission : <?= htmlspecialchars($mission['titre']) ?></h2>
    <p><strong>Période :</strong> <?= $mission['date_debut'] ?> → <?= $mission['date_fin'] ?></p>
    <p><strong>Type :</strong> <?= htmlspecialchars($mission['type_mission']) ?></p>
    <p><strong>Description :</strong> <?= nl2br(htmlspecialchars($mission['description'])) ?></p>
    <h4>Bénévoles inscrits</h4>
    <ul>
        <?php foreach ($benevoles as $b): ?>
            <li><?= htmlspecialchars($b['prenom'] . ' ' . $b['nom']) ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- ======================= AJOUT MATERIEL ======================= -->
    <div class="mt-5">
        <h4>Matériel associé</h4>

        <form method="POST" class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">Choisir du matériel</label>
                <select name="id_mat" class="form-select" required>
                    <option value="">-- Sélectionner un matériel --</option>
                    <?php foreach ($materiel_disponible as $m): ?>
                        <option value="<?= $m['id_mat'] ?>"><?= htmlspecialchars($m['nom_materiel']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Quantité</label>
                <input type="number" name="quantite" class="form-control" value="1" min="1" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-rose text-white w-100">Ajouter</button>
            </div>
        </form>

        <table class="table table-hover bg-white shadow-sm rounded">
            <thead class="bg-rose text-white">
            <tr>
                <th>Matériel</th>
                <th>Quantité</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($materiel_associe as $mat): ?>
                <tr>
                    <td><?= htmlspecialchars($mat['nom_materiel']) ?></td>
                    <td><?= $mat['quantite'] ?></td>
                    <td class="text-end">
                        <a href="?id=<?= $id ?>&delete_mat=<?= $mat['id_mat'] ?>" class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Supprimer ce matériel ?')">Supprimer</a>
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
