<?php
require_once 'config/db.php';
session_start();

$id = $_GET['id'] ?? null;

$data = [
    'titre' => '',
    'description' => '',
    'date_debut' => '',
    'date_fin' => '',
    'type_mission' => '',
    'nbr_benevole' => ''
];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM Mission WHERE id_mission = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $type_mission = $_POST['type_mission'] ?? '';
    $nbr_benevole = $_POST['nbr_benevole'] ?? 0;

    if ($id) {
        $sql = "
            UPDATE Mission 
            SET titre = ?, description = ?, date_debut = ?, date_fin = ?, type_mission = ?, nbr_benevole = ?
            WHERE id_mission = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $titre,
            $description,
            $date_debut,
            $date_fin,
            $type_mission,
            $nbr_benevole,
            $id
        ]);
    } else {
        $sql = "
            INSERT INTO Mission (titre, description, date_debut, date_fin, type_mission, nbr_benevole)
            VALUES (?,?,?,?,?,?)
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $titre,
            $description,
            $date_debut,
            $date_fin,
            $type_mission,
            $nbr_benevole
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
    <title>Mission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="navbar-container"></div>

<main class="container my-5">
    <h3><?= $id ? 'Modifier' : 'Nouvelle' ?> mission</h3>

    <form method="post" class="row g-3">
        <?php foreach ($data as $k => $v): ?>
            <div class="col-md-6">
                <label class="form-label"><?= ucfirst(str_replace('_',' ',$k)) ?></label>
                <input class="form-control" name="<?= $k ?>" value="<?= htmlspecialchars($v) ?>">
            </div>
        <?php endforeach; ?>
        <div class="col-12">
            <button class="btn btn-rose text-white">Enregistrer</button>
        </div>
    </form>
</main>

<div id="footer-container"></div>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
