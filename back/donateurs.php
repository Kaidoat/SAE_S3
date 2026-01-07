<?php
session_start();
if (!isset($_SESSION['donateur_id'])) {
    header("Location: espacedon.php");
    exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mon espace donateur</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<h1 class="section-title">Bienvenue 💖</h1>

<div id="dashboard">
    <p><strong>Total des dons :</strong> <span id="total">0 €</span></p>
</div>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Montant</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody id="historique"></tbody>
</table>

<a href="faireDon.php" class="btn-submit">Faire un don</a>
<a href="../back/logout-donateur.php" class="btn-submit">Se déconnecter</a>

<script src="../js/donateur.js"></script>
</body>
</html>
