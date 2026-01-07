<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['donateur_id'])) {
    header('Location: ../espacedon.php');
    exit;
}

$idDonateur = $_SESSION['donateur_id'];

$old = trim($_POST['old'] ?? '');
$new1 = trim($_POST['new1'] ?? '');
$new2 = trim($_POST['new2'] ?? '');

if ($old === '' || $new1 === '' || $new2 === '') {
    header('Location: ../espacedon.php?pwd_error=empty');
    exit;
}

if ($new1 !== $new2) {
    header('Location: ../espacedon.php?pwd_error=confirm');
    exit;
}

// 🔍 récupérer le mot de passe actuel
$stmt = $pdo->prepare("SELECT mdp_compte FROM Donateur WHERE id_donateur = ?");
$stmt->execute([$idDonateur]);
$mdpActuel = $stmt->fetchColumn();

// ❌ ancien mot de passe incorrect
if ($old !== $mdpActuel) {
    header('Location: ../espacedon.php?pwd_error=wrong');
    exit;
}

// ✅ mise à jour
$stmt = $pdo->prepare("
    UPDATE Donateur
    SET mdp_compte = ?
    WHERE id_donateur = ?
");
$stmt->execute([$new1, $idDonateur]);

// ✅ succès
header('Location: ../espacedon.php?pwd_success=1');
exit;
