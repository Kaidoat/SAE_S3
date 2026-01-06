<?php
require_once 'config/db.php';
$id = $_GET['id'] ?? null;

if ($id) {
    $pdo->prepare("DELETE FROM Mission WHERE id_mission=?")->execute([$id]);
}
header('Location: missions-evenements.php');
