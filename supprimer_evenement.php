<?php
session_start();
require('config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'admin') {
    $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: dashboard_admin.php");
} else {
    // Vérifie que l'utilisateur est bien le propriétaire
    $stmt = $pdo->prepare("SELECT * FROM evenements WHERE id = ? AND utilisateur_id = ?");
    $stmt->execute([$id, $user_id]);
    $event = $stmt->fetch();

    if ($event) {
        $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: dashboard_user.php");
}
exit;