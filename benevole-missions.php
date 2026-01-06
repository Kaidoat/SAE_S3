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

// Récupérer toutes les missions
$all_missions = $pdo->query("SELECT * FROM Mission ORDER BY date_debut DESC")->fetchAll(PDO::FETCH_ASSOC);

// Missions déjà associées au bénévole
$missions_benevole = $pdo->prepare("SELECT id_mission FROM Mission_Benevole WHERE id_benevole = ?");
$missions_benevole->execute([$id]);
$missions_benevole = $missions_benevole->fetchAll(PDO::FETCH_COLUMN);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['missions'] ?? [];

    // Supprimer toutes les anciennes associations
    $stmt = $pdo->prepare("DELETE FROM Mission_Benevole WHERE id_benevole = ?");
    $stmt->execute([$id]);

    // Ajouter les nouvelles associations
    $stmt = $pdo->prepare("INSERT INTO Mission_Benevole (id_mission, id_benevole) VALUES (?, ?)");
    foreach($selected as $mid) {
        $stmt->execute([$mid, $id]);
    }

    header("Location: benevole-detail.php?id=$id");
    exit;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Missions de <?= htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">
    <h2>Missions associées à <?= htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']) ?></h2>

    <form method="POST" class="mt-4">
        <div class="list-group mb-3">
            <?php foreach($all_missions as $m): ?>
                <label class="list-group-item">
                    <input type="checkbox" name="missions[]" value="<?= $m['id_mission'] ?>"
                        <?= in_array($m['id_mission'], $missions_benevole) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($m['titre']) ?> (<?= htmlspecialchars($m['type_mission']) ?>)
                </label>
            <?php endforeach; ?>
        </div>

        <button class="btn btn-rose text-white">Enregistrer les missions</button>
        <a href="benevole-detail.php?id=<?= $id ?>" class="btn btn-outline-secondary ms-2">Annuler</a>
    </form>
</main>

<div id="footer-container"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
