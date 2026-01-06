<?php
require_once 'config/db.php';
$id = $_GET['id'] ?? null;

if ($id) {
    $pdo->prepare("DELETE FROM Evenement WHERE id_evenement=?")->execute([$id]);
}
header('Location: missions-evenements.php');
