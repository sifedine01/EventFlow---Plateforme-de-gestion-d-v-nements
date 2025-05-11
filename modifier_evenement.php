<?php
session_start();
require('config.php');
if ($_SESSION['role'] !== 'user') {
    header("Location: connexion.php");
    exit;
}

$id = $_GET['id'];

// Récupérer les informations de l'événement
$stmt = $pdo->prepare("SELECT * FROM evenements WHERE id = ? AND utilisateur_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$event = $stmt->fetch();

if (!$event) {
    header("Location: dashboard_user.php");
    exit;
}
if ($event['statut'] === 'valide') {
    header("Location: dashboard_user.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $desc = $_POST['description'];
    $date = $_POST['date_event'];
    $lieu = $_POST['lieu'];

    $stmt = $pdo->prepare("UPDATE evenements SET titre = ?, description = ?, date_event = ?, lieu = ? WHERE id = ?");
    $stmt->execute([$titre, $desc, $date, $lieu, $id]);
    $valide = "Événement modifié ! <a href='dashboard_user.php'>Retour</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4f5f087331.js" crossorigin="anonymous"></script>
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
            max-width: 500px;
            margin: 20px auto;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        header a {
            font-size: 1.5rem;
            color: #3e4b58;
            transition: all 0.3s ease;
        }
        
        header a:hover {
            color: #11212d;
            transform: translateX(-3px);
        }
        
        header h2 {
            font-size: 1.8rem;
            color: #2d3748;
            font-weight: 700;
            margin-left: 15px;
            width: 100%;
            text-align: center;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 25px;
            background-color: #ebf8ff;
            color: #3182ce;
            font-weight: 500;
            border-left: 4px solid #3182ce;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 1rem;
        }
        
        input,
        textarea {
            width: 100%;
            padding: 14px 16px;
            font-size: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        input:focus,
        textarea:focus {
            outline: none;
            border-color: #3e4b58;
            box-shadow: 0 0 0 3px rgba(62, 75, 88, 0.1);
            background-color: white;
        }
        
        input[type="submit"] {
            background-color: #3e4b58;
            color: white;
            font-weight: 600;
            cursor: pointer;
            border: none;
            margin-top: 10px;
        }
        
        input[type="submit"]:hover {
            background-color: #11212d;
            transform: translateY(-2px);
        }
        
        @media (max-width: 480px) {
            .all {
                padding: 30px 20px;
            }
            
            header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="all">
        <header>
        <a href="dashboard_user.php"><i class="fa-solid fa-circle-chevron-left"></i></a>
            <h2>Modifier l'événement</h2>
        </header>
        <?php if (isset($valide)): ?>
            <div class="alert alert-success">
                <?= $valide ?>
            </div>
        <?php endif; ?>
        <form method="post">
            Titre: <input type="text" name="titre" value="<?= htmlspecialchars($event['titre']) ?>" required><br>
            Description: <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea><br>
            Date: <input type="date" name="date_event" value="<?= htmlspecialchars($event['date_event']) ?>" required><br>
            Lieu: <input type="text" name="lieu" value="<?= htmlspecialchars($event['lieu']) ?>" required><br>
            <input type="submit" value="Modifier">
        </form>
    </div>
</body>
</html>
