<?php
require_once '../config/db.php';
session_start();

$login = $_POST['login'];
$password = $_POST['password'];

$stmt = $pdo->prepare("
    SELECT * FROM utilisateur 
    WHERE login = ?
");
$stmt->execute([$login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification simple
if (!$user || $user['password_hash'] !== $password) {
    header("Location: ../login-interne.php?error=1");
    exit;
}

// Connexion OK
$_SESSION['user'] = $user['login'];
$_SESSION['role'] = $user['role'];

header("Location: ../espace-interne.php");
exit;
