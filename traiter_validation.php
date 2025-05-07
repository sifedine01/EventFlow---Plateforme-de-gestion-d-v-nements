<?php
session_start();
require('config.php');
if ($_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

$id = $_GET['id'];
$action = $_GET['action'];

if (in_array($action, ['valide', 'refuse'])) {
    $stmt = $pdo->prepare("UPDATE evenements SET statut = ? WHERE id = ?");
    $stmt->execute([$action, $id]);
}
header("Location: dashboard_admin.php");
