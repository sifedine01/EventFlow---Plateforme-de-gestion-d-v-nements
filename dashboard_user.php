<?php
session_start();
require('config.php');
if ($_SESSION['role'] !== 'user') {
    header("Location: connexion.php");
    exit;
}

$id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM evenements WHERE utilisateur_id = ?");
$stmt->execute([$id]);
$evenements = $stmt->fetchAll();
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$utilisateurs = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }
    
    body {
        background-image: url(./imgs/tree.jpg);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    
    .all {
        background-color: white;
        border-radius: 22px;
        width: 100%;
        max-width: 1100px;
        margin: 20px auto;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        color: #2d3748;
        font-weight: 700;
    }
    
    .welcome-message {
        color: #3e4b58;
        font-weight: 800;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 0 1px #e2e8f0;
    }
    
    th, td {
        padding: 14px 16px;
        text-align: center;
        border: 1px solid #e2e8f0;
    }
    
    th {
        background-color: #3e4b58;
        color: white;
        font-weight: 600;
    }
    
    tr:nth-child(even) {
        background-color: #f8fafc;
    }
    
    tr:hover {
        background-color: #f1f5f9;
    }
    
    .head {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 30px;
    }
    
    .head .A,
    .head .D,
    td a.R {
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        flex: 1;
    }
    
    .head .A,
    td a.R {
        background-color: #3e4b58;
        color: white;
        border: none;
    }
    
    .head .D {
        background-color: #f1f5f9;
        color: #3e4b58;
        border: 1px solid #e2e8f0;
    }
    
    .head .A:hover,
    td a.R:hover {
        background-color: #11212d;
        transform: translateY(-2px);
    }
    
    .head .D:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .all {
            padding: 30px 20px;
        }
        
        .head {
            flex-direction: column;
        }
        
        table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
</head>
<body>
    <div class="all">
    <h2>Bonjour <span class="welcome-message"><?= htmlspecialchars($utilisateurs['nom'] ?? 'Utilisateur') ?></span></h2>
<table border="1">
<tr>
    <th>Titre</th>
    <th>Date</th>
    <th>Lieu</th>
    <th>Statut</th>
    <th>Action</th>
</tr>
<?php foreach ($evenements as $event): ?>
<tr>
<td><?= $event['titre'] ?></td>
<td><?= $event['date_event'] ?></td>
<td><?= $event['lieu'] ?></td>
<td><?= $event['statut'] ?></td>
<td>
    <a class="R" href="supprimer_evenement.php?id=<?= $event['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet événement ?');">Supprimer</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<div class="head">
<a class="A" href="ajouter_evenement.php">Ajouter un événement</a>
<a class="D" href="logout.php">Déconnexion</a>
</div>
    </div>
</body>
</html>
