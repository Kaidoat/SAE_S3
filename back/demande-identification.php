<?php
require_once '../config/db.php';
session_start();

// Sécurité basique
if ($_POST['captcha_valid'] !== '1') {
    header("Location: ../login-interne.php?error=captcha");
    exit;
}

// Récupération
$prenom   = trim($_POST['prenom']);
$nom      = trim($_POST['nom']);
$email    = trim($_POST['email']);
$adresse  = trim($_POST['adresse']);
$cp       = trim($_POST['cp']);
$ville    = trim($_POST['ville']);
$tel      = trim($_POST['telephone']);
$role     = $_POST['role'];
$password = $_POST['password'];
$confirm  = $_POST['password_confirm'];

// 1️⃣ Vérification mot de passe
if ($password !== $confirm) {
    die("❌ Les mots de passe ne correspondent pas");
}

// 2️⃣ Génération login simple
$login = strtolower($prenom . "." . $nom);

// 3️⃣ Vérifier si utilisateur existe déjà
$check = $pdo->prepare("
    SELECT id_utilisateur 
    FROM utilisateur 
    WHERE login = ? OR email = ?
");
$check->execute([$login, $email]);

if ($check->fetch()) {
    die("❌ Utilisateur déjà existant");
}

// 4️⃣ Récupération id_ville
$stmtVille = $pdo->prepare("SELECT id_ville FROM ville WHERE nom = ?");
$stmtVille->execute([$ville]);
$idVille = $stmtVille->fetchColumn();

if (!$idVille) {
    die("❌ Ville inconnue");
}

// 5️⃣ INSERT utilisateur (mot de passe EN CLAIR)
$stmt = $pdo->prepare("
    INSERT INTO utilisateur 
    (login, password_hash, role, nom, prenom, email, telephone, adresse, code_postal, id_ville)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $login,
    $password, // 👈 mot de passe en clair (SAE)
    $role,
    $nom,
    $prenom,
    $email,
    $tel,
    $adresse,
    $cp,
    $idVille
]);

header("Location: ../login-interne.php?success=1");
exit;
