<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: Benevole-panneau.php');
    exit;
}

// Récupérer le bénévole
$stmt = $pdo->prepare("SELECT prenom, nom FROM Benevole WHERE id_benevole = ?");
$stmt->execute([$id]);
$benevole = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$benevole) {
    header('Location: Benevole-panneau.php');
    exit;
}

// ===== MISSIONS =====
$all_missions = $pdo->query("SELECT * FROM Mission ORDER BY date_debut DESC")->fetchAll(PDO::FETCH_ASSOC);
$missions_benevole = $pdo->prepare("SELECT id_mission FROM Mission_Benevole WHERE id_benevole = ?");
$missions_benevole->execute([$id]);
$missions_benevole = $missions_benevole->fetchAll(PDO::FETCH_COLUMN);

// ===== EVENEMENTS =====
$all_evenements = $pdo->query("SELECT * FROM Evenement ORDER BY date_event DESC")->fetchAll(PDO::FETCH_ASSOC);
$evenements_benevole = $pdo->prepare("SELECT id_evenement FROM Evenement_Benevole WHERE id_benevole = ?");
$evenements_benevole->execute([$id]);
$evenements_benevole = $evenements_benevole->fetchAll(PDO::FETCH_COLUMN);

// ===== TRAITEMENT FORMULAIRE =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_missions = $_POST['missions'] ?? [];
    $selected_evenements = $_POST['evenements'] ?? [];

    // Supprimer les anciennes associations
    $pdo->prepare("DELETE FROM Mission_Benevole WHERE id_benevole = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM Evenement_Benevole WHERE id_benevole = ?")->execute([$id]);

    // Ajouter les nouvelles associations
    $stmt_m = $pdo->prepare("INSERT INTO Mission_Benevole (id_mission, id_benevole) VALUES (?, ?)");
    foreach ($selected_missions as $mid) {
        $stmt_m->execute([$mid, $id]);
    }

    $stmt_e = $pdo->prepare("INSERT INTO Evenement_Benevole (id_evenement, id_benevole) VALUES (?, ?)");
    foreach ($selected_evenements as $eid) {
        $stmt_e->execute([$eid, $id]);
    }

    header("Location: benevole-detail.php?id=$id");
    exit;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Missions et événements de <?= htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">
    <h2>Missions et événements de <?= htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']) ?></h2>

    <form method="POST" class="mt-4">

        <!-- ===== MISSIONS ===== -->
        <div class="mb-4">
            <h4 class="mb-3">Missions</h4>
            <div class="list-group">
                <?php foreach($all_missions as $m): ?>
                    <label class="list-group-item">
                        <input type="checkbox" name="missions[]" value="<?= $m['id_mission'] ?>"
                                <?= in_array($m['id_mission'], $missions_benevole) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($m['titre']) ?> (<?= htmlspecialchars($m['type_mission']) ?>)
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ===== EVENEMENTS ===== -->
        <div class="mb-4">
            <h4 class="mb-3">Événements</h4>
            <div class="list-group">
                <?php foreach($all_evenements as $e): ?>
                    <label class="list-group-item">
                        <input type="checkbox" name="evenements[]" value="<?= $e['id_evenement'] ?>"
                                <?= in_array($e['id_evenement'], $evenements_benevole) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($e['nom']) ?> (<?= htmlspecialchars($e['type_evenement']) ?>)
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button class="btn btn-rose text-white">Enregistrer</button>
        <a href="benevole-detail.php?id=<?= $id ?>" class="btn btn-outline-secondary ms-2">Annuler</a>

    </form>
</main>

<div id="footer-container"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
