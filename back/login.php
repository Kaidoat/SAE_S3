<?php
session_start();
require_once '../config/db.php';

if ($_POST) {
    $stmt = $pdo->prepare(
        "SELECT * FROM Utilisateur WHERE login = ?"
    );
    $stmt->execute([$_POST['login']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['utilisateur'] = [
            'id'   => $user['id_utilisateur'],
            'role' => $user['role'],
            'login'=> $user['login']
        ];
        header('Location: /index.php');
        exit;
    }
}
