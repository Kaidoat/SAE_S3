<?php
require_once 'config/db.php';
$id = $_GET['id'] ?? null;

if ($id) {
    $pdo->prepare("DELETE FROM Benevole WHERE id_benevole=?")->execute([$id]);
}
header('Location: Benevole-panneau.php');
