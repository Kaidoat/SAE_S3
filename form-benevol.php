<?php
session_start();
require_once 'config/db.php';

// Protection d'accès
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$message = "";

// Traitement du formulaire lors de l'envoi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $tel = $_POST['telephone'];
    $ville = $_POST['id_ville'];
    $dispo = $_POST['disponibilite'];
    $date_n = $_POST['date_naissance'];
    $statut = "Actif"; // Par défaut

    try {
        $sql = "INSERT INTO Benevole (prenom, nom, email, telephone, id_ville, disponibilite, date_naissance, statut) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$prenom, $nom, $email, $tel, $ville, $dispo, $date_n, $statut]);

        $message = "<div class='alert alert-success'>Bénévole ajouté avec succès !</div>";
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
    }
}
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-rose text-white text-center py-3">
                        <h4 class="mb-0">Ajouter un nouveau membre</h4>
                    </div>
                    <div class="card-body p-4">
                        <?= $message ?>

                        <form action="" method="POST" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" name="date_naissance" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ville de rattachement</label>
                                <select name="id_ville" class="form-select" required>
                                    <option value="">Choisir une ville...</option>
                                    <?php
                                    $villes = $pdo->query("SELECT * FROM Ville ORDER BY nom ASC")->fetchAll();
                                    foreach($villes as $v) {
                                        echo "<option value='{$v['id_ville']}'>{$v['nom']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Disponibilités (ex: Samedi, Soirs...)</label>
                                <input type="text" name="disponibilite" class="form-control" placeholder="Libre le week-end">
                            </div>

                            <div class="col-12 d-flex justify-content-between mt-4">
                                <a href="Benevole-panneau.php" class="btn btn-outline-secondary">Annuler</a>
                                <button type="submit" class="btn btn-rose text-white">Enregistrer le bénévole</button>
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