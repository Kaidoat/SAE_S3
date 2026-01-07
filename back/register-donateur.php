<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../espacedon.php');
    exit;
}

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$mdp = trim($_POST['motdepasse'] ?? '');
$mdp2 = trim($_POST['confirm_motdepasse'] ?? '');

if ($nom === '' || $prenom === '' || $email === '' || $mdp === '' || $mdp !== $mdp2) {
    header('Location: ../espacedon.php?register_error=1');
    exit;
}

// Vérifier email existant
$stmt = $pdo->prepare("SELECT id_donateur FROM Donateur WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    header('Location: ../espacedon.php?register_error=exists');
    exit;
}

// INSERT SANS HASH
$stmt = $pdo->prepare("
    INSERT INTO Donateur (nom, prenom, email, mdp_compte, type_donateur)
    VALUES (?, ?, ?, ?, 'particulier')
");
$stmt->execute([$nom, $prenom, $email, $mdp]);

// Connexion auto
$_SESSION['donateur_id'] = $pdo->lastInsertId();
$_SESSION['donateur_email'] = $email;
$_SESSION['donateur_nom'] = $nom;
$_SESSION['donateur_prenom'] = $prenom;

header('Location: ../espacedon.php');
exit;
