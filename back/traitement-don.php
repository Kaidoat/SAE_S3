<?php
require_once '../config/db.php';

// Sécurité basique
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: faireDon.php');
    exit;
}

// 1️⃣ Récupération des données
$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$adresse = trim($_POST['adresse']);
$cp = trim($_POST['cp']);
$ville = trim($_POST['ville']);
$telephone = trim($_POST['telephone'] ?? '');
$mode_paiement = $_POST['mode_paiement'] ?? 'Inconnu';

// 2️⃣ Calcul du montant
$montant = null;

if (!empty($_POST['don_unique'])) {
    $montant = $_POST['don_unique'];
} elseif (!empty($_POST['autreMontantUnique'])) {
    $montant = $_POST['autreMontantUnique'];
} elseif (!empty($_POST['don_mensuel'])) {
    $montant = $_POST['don_mensuel'];
} elseif (!empty($_POST['autreMontantMensuel'])) {
    $montant = $_POST['autreMontantMensuel'];
}

if (!$montant || $montant <= 0) {
    die("Montant invalide");
}

// 3️⃣ Vérifier si le donateur existe déjà
$sql = "SELECT id_donateur FROM Donateur WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$donateur = $stmt->fetch();

if ($donateur) {
    $id_donateur = $donateur['id_donateur'];
} else {
    // 4️⃣ Création du donateur
    // Mot de passe par défaut : prenom.nom (en minuscules)
    $mdp_defaut = strtolower($prenom . "." . $nom);

    $sql = "INSERT INTO Donateur (nom, prenom, email, type_donateur,mdp_compte)
            VALUES (?, ?, ?, 'particulier', ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $mdp_defaut]);
    $id_donateur = $pdo->lastInsertId();
}

// 5️⃣ Insertion du don
$sql = "INSERT INTO Don (montant, date_don, type_don, id_donateur)
        VALUES (?, CURDATE(), ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$montant, $mode_paiement, $id_donateur]);

// 6️⃣ Redirection
header('Location: ../faireDon.php?success=1');
exit;

