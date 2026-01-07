<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: missions-evenements.php');
    exit;
}

/* ===== EVENEMENT ===== */
$evenement = $pdo->prepare("SELECT * FROM Evenement WHERE id_evenement = ?");
$evenement->execute([$id]);
$evenement = $evenement->fetch();

if (!$evenement) {
    die("Événement introuvable");
}

/* ===== BENEVOLES ===== */
$benevoles = $pdo->prepare("
    SELECT b.prenom, b.nom
    FROM Evenement_Benevole eb
    JOIN Benevole b ON eb.id_benevole = b.id_benevole
    WHERE eb.id_evenement = ?
");
$benevoles->execute([$id]);
$benevoles = $benevoles->fetchAll();

/* ===== MEDIAS DISPONIBLES ===== */
$medias = $pdo->query("
    SELECT id_media, nom_media, type_media
    FROM Media
    ORDER BY nom_media
")->fetchAll();

/* ===== AJOUT DOCUMENT VIA MENU ===== */
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_media = $_POST['id_media'];

    $stmt = $pdo->prepare("
        INSERT INTO Evenement_Media (id_evenement, id_media)
        VALUES (?, ?)
    ");
    $stmt->execute([$id, $id_media]);

    $message = "<div class='alert alert-success'>Document associé à l'événement</div>";
}

/* ===== DOCUMENTS DE L'ÉVÉNEMENT ===== */
$documents = $pdo->prepare("
    SELECT m.nom_media, m.type_media
    FROM Media m
    JOIN Evenement_Media em ON m.id_media = em.id_media
    WHERE em.id_evenement = ?
");
$documents->execute([$id]);
$documents = $documents->fetchAll();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Détail événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">

    <a href="missions-evenements.php" class="btn btn-outline-secondary mb-3">← Retour</a>

    <h2><?= htmlspecialchars($evenement['nom']) ?></h2>
    <p>
        <strong>Date :</strong> <?= $evenement['date_event'] ?><br>
        <strong>Type :</strong> <?= htmlspecialchars($evenement['type_evenement']) ?><br>
        <strong>Logistique :</strong> <?= htmlspecialchars($evenement['logistique']) ?>
    </p>

    <hr>

    <h4>Bénévoles inscrits</h4>
    <ul>
        <?php foreach ($benevoles as $b): ?>
            <li><?= htmlspecialchars($b['prenom'] . ' ' . $b['nom']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h4>Documents associés</h4>
    <?= $message ?>
    <ul>
        <?php foreach ($documents as $d): ?>
            <li><?= htmlspecialchars($d['nom_media']) ?> (<?= $d['type_media'] ?>)</li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" class="row g-2 mt-3">
        <div class="col-md-10">
            <select name="id_media" class="form-select" required>
                <option value="">— Sélectionner un document —</option>
                <?php foreach ($medias as $m): ?>
                    <option value="<?= $m['id_media'] ?>">
                        <?= htmlspecialchars($m['nom_media']) ?> (<?= $m['type_media'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-rose text-white w-100">Ajouter</button>
        </div>
    </form>

</main>

<div id="footer-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
