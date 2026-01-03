<?php
session_start();
require_once '../config/db.php';

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// mot de passe EN CLAIR (SAE)
if ($user && $password === $user['password_hash']) {
    $_SESSION['user'] = $user['login'];
    $_SESSION['role'] = $user['role'];

    header("Location: ../espace-interne.php");
    exit;
}

// sinon erreur
header("Location: ../login-interne.php?error=1");
exit;
