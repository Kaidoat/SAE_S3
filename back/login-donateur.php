<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../espacedon.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$motdepasse = trim($_POST['motdepasse'] ?? '');

if ($email === '' || $motdepasse === '') {
    header('Location: ../espacedon.php?error=1');
    exit;
}

// 🔍 Recherche du donateur par EMAIL
$stmt = $pdo->prepare("
    SELECT id_donateur, nom, prenom, mdp_compte
    FROM Donateur
    WHERE email = ?
");
$stmt->execute([$email]);
$donateur = $stmt->fetch(PDO::FETCH_ASSOC);

// ❌ Email inconnu
if (!$donateur) {
    header('Location: ../espacedon.php?error=1');
    exit;
}

// ❌ Mot de passe incorrect (EN CLAIR)
if ($motdepasse !== $donateur['mdp_compte']) {
    header('Location: ../espacedon.php?error=1');
    exit;
}

// ✅ Connexion OK
$_SESSION['donateur_id'] = $donateur['id_donateur'];
$_SESSION['donateur_email'] = $email;
$_SESSION['donateur_nom'] = $donateur['nom'];
$_SESSION['donateur_prenom'] = $donateur['prenom'];

header('Location: ../espacedon.php');
exit;
