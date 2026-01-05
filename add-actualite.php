<?php
session_start();
require_once 'config/db.php';

// Protection : Admin ou Responsable uniquement
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $resume = $_POST['resume'];
    $image_url = $_POST['image_url'];
    $lien = $_POST['lien'];
    $date_pub = $_POST['date_publication'] ?: date('Y-m-d');

    try {
        $sql = "INSERT INTO Actualite (titre, resume, image_url, lien, date_publication) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $resume, $image_url, $lien, $date_pub]);
        $message = "<div class='alert alert-success shadow-sm'>L'actualité a été publiée avec succès !</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
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
                            <label class="form-label fw-bold">Titre de l'article</label>
                            <input type="text" name="titre" class="form-control" placeholder="Ex: Grand loto de Noël" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Résumé / Corps du texte</label>
                            <textarea name="resume" class="form-control" rows="5" placeholder="Décrivez l'événement..." required></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">URL de l'image</label>
                                <input type="text" name="image_url" class="form-control" placeholder="https://exemple.com/image.jpg">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Lien "En savoir plus"</label>
                                <input type="text" name="lien" class="form-control" placeholder="https://google.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Date de publication</label>
                            <input type="date" name="date_publication" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="d-flex justify-content-between border-top pt-3">
                            <a href="espace-interne.php" class="btn btn-outline-secondary">Retour</a>
                            <button type="submit" class="btn btn-rose text-white px-4">Publier l'actualité</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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