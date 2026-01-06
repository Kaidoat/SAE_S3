<?php
require_once 'config/db.php';
session_start();

// Accès réservé
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$id = $_GET['id'] ?? null;

/* ===============================
   Valeurs par défaut
================================ */
$nom = '';
$type_evenement = '';
$date_event = '';
$logistique = '';

/* ===============================
   Chargement si modification
================================ */
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Evenement WHERE id_evenement = ?");
    $stmt->execute([$id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        $nom = $event['nom'];
        $type_evenement = $event['type_evenement'];
        $date_event = $event['date_event'];
        $logistique = $event['logistique'];
    }
}

/* ===============================
   Traitement formulaire
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'] ?? '';
    $type_evenement = $_POST['type_evenement'] ?? '';
    $date_event = $_POST['date_event'] ?? '';
    $logistique = $_POST['logistique'] ?? '';

    if ($id) {
        // UPDATE
        $sql = "
            UPDATE Evenement
            SET nom = ?, type_evenement = ?, date_event = ?, logistique = ?
            WHERE id_evenement = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nom,
            $type_evenement,
            $date_event,
            $logistique,
            $id
        ]);
    } else {
        // INSERT
        $sql = "
            INSERT INTO Evenement (nom, type_evenement, date_event, logistique)
            VALUES (?,?,?,?)
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $nom,
            $type_evenement,
            $date_event,
            $logistique
        ]);
    }

    header('Location: missions-evenements.php');
    exit;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $id ? 'Modifier' : 'Nouvel' ?> événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">

    <h3 class="mb-4"><?= $id ? 'Modifier' : 'Créer' ?> un événement</h3>

    <form method="post" class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Nom de l’événement</label>
            <input type="text" name="nom" class="form-control" required
                   value="<?= htmlspecialchars($nom) ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Type d’événement</label>
            <input type="text" name="type_evenement" class="form-control"
                   value="<?= htmlspecialchars($type_evenement) ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Date</label>
            <input type="date" name="date_event" class="form-control"
                   value="<?= htmlspecialchars($date_event) ?>">
        </div>

        <div class="col-12">
            <label class="form-label">Logistique</label>
            <textarea name="logistique" class="form-control" rows="4"><?= htmlspecialchars($logistique) ?></textarea>
        </div>

        <div class="col-12">
            <button class="btn btn-rose text-white">Enregistrer</button>
            <a href="missions-evenements.php" class="btn btn-outline-secondary ms-2">Annuler</a>
        </div>

    </form>

</main>

<div id="footer-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>

</body>
</html>
