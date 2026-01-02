<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}
