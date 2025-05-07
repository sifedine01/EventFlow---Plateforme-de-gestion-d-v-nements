<?php
session_start();
require('config.php');
if ($_SESSION['role'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

$stmt = $pdo->query("SELECT e.*, u.nom FROM evenements e JOIN utilisateurs u ON e.utilisateur_id = u.id");
$evenements = $stmt->fetchAll();
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
    
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    header h1 {
        font-size: 1.8rem;
        color: #2d3748;
        font-weight: 700;
    }
    
    header a {
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        background-color:#470707;
        color: white;
    }
    
    header a:hover {
        background-color:rgb(34, 3, 3);
        transform: translateY(-2px);
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
    
    .V, .R, .pdf {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        margin: 2px;
    }
    
    .V, .R {
        color: white;
        background-color: #3e4b58;
    }
    
    .pdf {
        background-color: #3e4b58;
        color: white;
        margin-top: 20px;
        text-align: center;
        width: 200px;
        padding: 12px;
    }
    
    .V:hover, .R:hover, .pdf:hover {
        background-color: #11212d;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .all {
            padding: 30px 20px;
        }
        
        header {
            flex-direction: column;
            gap: 15px;
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
     <header>
     <h1>Dashboard Admin</h1>
     <a href="logout.php">Déconnexion</a>
     </header>
     <table border="1">
      <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>Utilisateur</th>
        <th>Statut</th>
        <th>Action</th>
        </tr>
      <?php foreach ($evenements as $event): ?>
      <tr>
        <td><?= $event['id'] ?></td>
        <td><?= $event['titre'] ?></td>
        <td><?= $event['nom'] ?></td>
        <td><?= $event['statut'] ?></td>
        <td>
         <a class="V" href="traiter_validation.php?id=<?= $event['id'] ?>&action=valide">Valider</a> |
         <a class="R" href="traiter_validation.php?id=<?= $event['id'] ?>&action=refuse">Refuser</a>
         <?php if ($event['statut'] === 'refuse'): ?>|
         <a class="R" href="supprimer_evenement.php?id=<?= $event['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
         <?php endif; ?>
        </td>
      </tr>
      <?php endforeach; ?>
     </table>
     <a class="pdf" href="export_pdf.php" target="_blank">Exporter en PDF</a>
</div>
</body>
</html>