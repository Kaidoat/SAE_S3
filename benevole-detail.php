<?php
session_start();
require_once 'config/db.php';

// Accès réservé
if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: Benevole-panneau.php');
    exit;
}

// Récupération des infos du bénévole
$stmt = $pdo->prepare("
    SELECT b.*, v.nom AS ville_nom
    FROM Benevole b
    LEFT JOIN Ville v ON b.id_ville = v.id_ville
    WHERE b.id_benevole = ?
");
$stmt->execute([$id]);
$benevole = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$benevole) {
    header('Location: Benevole-panneau.php');
    exit;
}

// Compétences
$competences = $pdo->prepare("
    SELECT c.libelle
    FROM Benevole_Competence bc
    JOIN Competence c ON bc.id_competence = c.id_competence
    WHERE bc.id_benevole = ?
");
$competences->execute([$id]);
$competences = $competences->fetchAll(PDO::FETCH_COLUMN);

// Régimes alimentaires
$regimes = $pdo->prepare("
    SELECT r.type
    FROM Benevole_Regime br
    JOIN Regime_alimentaire r ON br.id_reg = r.id_reg
    WHERE br.id_benevole = ?
");
$regimes->execute([$id]);
$regimes = $regimes->fetchAll(PDO::FETCH_COLUMN);

// Contraintes
$contraintes = $pdo->prepare("
    SELECT c.type_contrainte, c.description
    FROM Benevole_Contrainte bc
    JOIN Contrainte c ON bc.id_contrainte = c.id_contrainte
    WHERE bc.id_benevole = ?
");
$contraintes->execute([$id]);
$contraintes = $contraintes->fetchAll(PDO::FETCH_ASSOC);

// Missions
$missions = $pdo->prepare("
    SELECT m.titre, m.type_mission, m.date_debut, m.date_fin
    FROM Mission_Benevole mb
    JOIN Mission m ON mb.id_mission = m.id_mission
    WHERE mb.id_benevole = ?
    ORDER BY m.date_debut DESC
");
$missions->execute([$id]);
$missions = $missions->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Détail Bénévole — <?= htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div id="navbar-container"></div>

<main class="container my-5">
    <h2 class="mb-4">Détails du bénévole</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4><?= htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']) ?></h4>
            <p><strong>Email:</strong> <?= htmlspecialchars($benevole['email']) ?></p>
            <p><strong>Téléphone:</strong> <?= htmlspecialchars($benevole['telephone']) ?></p>
            <p><strong>Date de naissance:</strong> <?= htmlspecialchars($benevole['date_naissance']) ?></p>
            <p><strong>Ville:</strong> <?= htmlspecialchars($benevole['ville_nom']) ?></p>
            <p><strong>Disponibilité:</strong> <?= htmlspecialchars($benevole['disponibilite']) ?></p>
            <p><strong>Statut:</strong> <?= htmlspecialchars($benevole['statut']) ?></p>

            <hr>
            <h5>Compétences</h5>
            <ul>
                <?php foreach($competences as $c): ?>
                    <li><?= htmlspecialchars($c) ?></li>
                <?php endforeach; ?>
            </ul>

            <h5>Régimes alimentaires</h5>
            <ul>
                <?php foreach($regimes as $r): ?>
                    <li><?= htmlspecialchars($r) ?></li>
                <?php endforeach; ?>
            </ul>

            <h5>Contraintes</h5>
            <ul>
                <?php foreach($contraintes as $c): ?>
                    <li><strong><?= htmlspecialchars($c['type_contrainte']) ?>:</strong> <?= htmlspecialchars($c['description']) ?></li>
                <?php endforeach; ?>
            </ul>

            <h5>Missions effectuées</h5>
            <ul>
                <?php foreach($missions as $m): ?>
                    <li>
                        <?= htmlspecialchars($m['titre']) ?>
                        (<?= htmlspecialchars($m['type_mission']) ?>, du <?= htmlspecialchars($m['date_debut']) ?> au <?= htmlspecialchars($m['date_fin']) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="mt-4">
                <a href="form-benevole.php?id=<?= $benevole['id_benevole'] ?>" class="btn btn-primary">Modifier</a>
                <a href="Benevole-panneau.php" class="btn btn-outline-secondary">Retour au tableau</a>
            </div>
        </div>
    </div>
</main>

<div id="footer-container"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/navbar.js"></script>
<script src="js/footer.js"></script>
</body>
</html>
