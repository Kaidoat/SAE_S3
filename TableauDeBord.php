<?php
session_start();


if (!isset($_SESSION['user'])) {
    header('Location: login-interne.php');
    exit;
}

require 'config/db.php';
$user_role = $_SESSION['role'] ?? 'benevole';

$annee = date('Y');


// stats principales


// Nombre de bénévoles actifs
$nbBenevoles = $pdo->query("SELECT COUNT(*) FROM Benevole WHERE statut='Actif'")->fetchColumn();

// Nouvelles inscriptions cette année
$nbInscriptions = $pdo->query("SELECT COUNT(*) FROM Benevole WHERE YEAR(date_naissance) = $annee")->fetchColumn();

// Missions réalisées cette année
$missionsRealisees = $pdo->query("SELECT COUNT(*) FROM Mission WHERE YEAR(date_fin) = $annee")->fetchColumn();

// Taux de participation aux missions (total bénévoles assignés / total missions)
$totalAssignments = $pdo->query("SELECT COUNT(*) FROM Mission_Benevole")->fetchColumn();
$totalMissions = $pdo->query("SELECT COUNT(*) FROM Mission")->fetchColumn();
$tauxParticipation = $totalMissions > 0 ? round(($totalAssignments / ($totalMissions * $nbBenevoles)) * 100, 2) : 0;

// Montant total des dons
$montantDons = $pdo->query("SELECT IFNULL(SUM(montant),0) FROM Don")->fetchColumn();

// Montant total des cotisations
$montantCotisations = 0;

// Répartition par âge
$ages = $pdo->query("
    SELECT 
        CASE 
            WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
            WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 26 AND 35 THEN '26-35'
            WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 36 AND 50 THEN '36-50'
            ELSE '50+' 
        END AS tranche_age,
        COUNT(*) AS nb
    FROM Benevole
    GROUP BY tranche_age
")->fetchAll(PDO::FETCH_ASSOC);

// Répartition par origine
$origines = $pdo->query("
    SELECT origine, COUNT(*) AS nb
    FROM Benevole
    GROUP BY origine
")->fetchAll(PDO::FETCH_ASSOC);

// Répartition par profession/statut
$professions = $pdo->query("
    SELECT statut, COUNT(*) AS nb
    FROM Benevole
    GROUP BY statut
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Tableau de bord — Les Blouses Roses</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="container my-5">

<h1 class="text-center mb-4">Tableau de bord de l’association</h1>

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card text-center shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-people-fill display-5 text-primary"></i>
                <h5 class="mt-2">Bénévoles actifs</h5>
                <p class="fw-bold fs-4 mb-0"><?= $nbBenevoles ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-person-plus-fill display-5 text-success"></i>
                <h5 class="mt-2">Nouvelles inscriptions</h5>
                <p class="fw-bold fs-4 mb-0"><?= $nbInscriptions ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-check2-circle display-5 text-warning"></i>
                <h5 class="mt-2">Missions réalisées</h5>
                <p class="fw-bold fs-4 mb-0"><?= $missionsRealisees ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-bar-chart-line display-5 text-info"></i>
                <h5 class="mt-2">Taux participation missions</h5>
                <p class="fw-bold fs-4 mb-0"><?= $tauxParticipation ?> %</p>
            </div>
        </div>
    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card text-center shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-currency-euro display-5 text-danger"></i>
                <h5 class="mt-2">Montant des dons</h5>
                <p class="fw-bold fs-4 mb-0"><?= $montantDons ?> €</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center shadow-sm h-100">
            <div class="card-body">
                <i class="bi bi-wallet2 display-5 text-secondary"></i>
                <h5 class="mt-2">Montant cotisations</h5>
                <p class="fw-bold fs-4 mb-0"><?= $montantCotisations ?> €</p>
            </div>
        </div>
    </div>

</div>

<h3 class="mt-5 mb-3">Répartition des bénévoles</h3>
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <canvas id="ageChart"></canvas>
    </div>
    <div class="col-md-4">
        <canvas id="origineChart"></canvas>
    </div>
    <div class="col-md-4">
        <canvas id="professionChart"></canvas>
    </div>
</div>

<div class="text-center mt-5">
    <a href="espace-interne.php" class="btn btn-outline-secondary">← Retour</a>
</div>

<!-- Passage des données PHP vers JS -->
<script>
    const ages = <?= json_encode($ages) ?>;
    const origines = <?= json_encode($origines) ?>;
    const professions = <?= json_encode($professions) ?>;
</script>
<script src="js/graph.js"></script>
</body>
</html>
