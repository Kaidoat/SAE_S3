<?php
session_start();
require_once 'config/db.php';

// Protection : Admin ou Responsable uniquement
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$message = "";

// Récupération des missions et événements pour les menus déroulants
$missions = $pdo->query("SELECT id_mission, titre FROM Mission ORDER BY date_debut DESC")->fetchAll();
$evenements = $pdo->query("SELECT id_evenement, nom FROM Evenement ORDER BY date_event DESC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $resume = $_POST['resume'];
    $image_url = $_POST['image_url'];
    $lien = $_POST['lien'];
    $date_pub = $_POST['date_publication'] ?: date('Y-m-d');

    $id_mission = !empty($_POST['id_mission']) ? $_POST['id_mission'] : null;
    $id_evenement = !empty($_POST['id_evenement']) ? $_POST['id_evenement'] : null;

    // Sécurité : une actualité ne peut pas être liée aux deux
    if ($id_mission && $id_evenement) {
        $message = "<div class='alert alert-warning'>Veuillez sélectionner soit une mission, soit un événement (pas les deux).</div>";
    } else {
        try {
            $sql = "INSERT INTO Actualite 
                    (titre, resume, image_url, lien, date_publication, id_mission, id_evenement)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                    $titre,
                    $resume,
                    $image_url,
                    $lien,
                    $date_pub,
                    $id_mission,
                    $id_evenement
            ]);

            $message = "<div class='alert alert-success shadow-sm'>L'actualité a été publiée avec succès !</div>";
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nouvelle Actualité — Les Blouses Roses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main id="contenu" class="container my-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-rose text-white py-3">
                        <h4 class="mb-0"><i class="bi bi-newspaper me-2"></i> Publier une actualité</h4>
                    </div>

                    <div class="card-body p-4">
                        <?= $message ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Titre</label>
                                <input type="text" name="titre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Contenu</label>
                                <textarea name="resume" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Mission associée (optionnel)</label>
                                    <select name="id_mission" class="form-select">
                                        <option value="">— Aucune mission —</option>
                                        <?php foreach ($missions as $m): ?>
                                            <option value="<?= $m['id_mission'] ?>">
                                                <?= htmlspecialchars($m['titre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Événement associé (optionnel)</label>
                                    <select name="id_evenement" class="form-select">
                                        <option value="">— Aucun événement —</option>
                                        <?php foreach ($evenements as $e): ?>
                                            <option value="<?= $e['id_evenement'] ?>">
                                                <?= htmlspecialchars($e['nom']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Image (URL)</label>
                                    <input type="text" name="image_url" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Lien externe</label>
                                    <input type="text" name="lien" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Date de publication</label>
                                <input type="date" name="date_publication" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="d-flex justify-content-between border-top pt-3">
                                <a href="espace-interne.php" class="btn btn-outline-secondary">Retour</a>
                                <button type="submit" class="btn btn-rose text-white px-4">Publier</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div id="footer-container"></div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
<script src="js/interne.js"></script>

</body>
</html>
