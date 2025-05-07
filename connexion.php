<?php
session_start();
require('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];
        if ($user['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_user.php");
        }
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
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
        display: flex;
        width: 100%;
        max-width: 1100px;
        height: auto;
        margin: 20px auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    .sec1 {
        width: 50%;
        background-image: url(./imgs/first.png);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 60px 40px;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .sec1::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(30, 40, 60, 0.7);
        z-index: -1;
        border-radius: 20px 0 0 20px;
    }
    
    .sec1 h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 25px;
        line-height: 1.3;
    }
    
    .sec1 p {
        font-size: 1.1rem;
        line-height: 1.6;
        opacity: 0.9;
    }
    
    .sec2 {
        width: 50%;
        padding: 50px 40px;
        background-color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .sec2 h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        color: #2d3748;
        font-weight: 700;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .sec2 label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4a5568;
        font-size: 1rem;
    }
    
    .sec2 input {
        width: 100%;
        padding: 14px 16px;
        font-size: 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }
    
    .sec2 input:focus {
        outline: none;
        border-color: #3e4b58;
        box-shadow: 0 0 0 3px rgba(62, 75, 88, 0.1);
        background-color: white;
    }
    
    .chose {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 25px;
    }
    
    .chose input[type="submit"],
    .chose a {
        padding: 14px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }
    
    .chose input[type="submit"] {
        background-color: #3e4b58;
        color: white;
    }
    
    .chose input[type="submit"]:hover {
        background-color: #11212d;
        transform: translateY(-2px);
    }
    
    .chose a {
        background-color: #f1f5f9;
        color: #3e4b58;
        text-decoration: none;
        border: 1px solid #e2e8f0;
    }
    
    .chose a:hover {
        background-color: #e2e8f0;
        transform: translateY(-2px);
    }
    
    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        background-color: #fff5f5;
        color: #c53030;
        font-weight: 500;
        border-left: 4px solid #c53030;
    }
    
    /* Responsive adjustments */
    @media (max-width: 900px) {
        .all {
            flex-direction: column;
            max-width: 500px;
        }
        
        .sec1,
        .sec2 {
            width: 100%;
        }
        
        .sec1 {
            border-radius: 20px 20px 0 0;
            padding: 40px 30px;
        }
        
        .sec1::before {
            border-radius: 20px 20px 0 0;
        }
        
        .sec2 {
            border-radius: 0 0 20px 20px;
            padding: 40px 30px;
        }
    }
    
    @media (max-width: 480px) {
        .sec1 h1 {
            font-size: 2rem;
        }
        
        .sec2 h2 {
            font-size: 1.5rem;
        }
        
        .chose {
            flex-direction: column;
        }
        
        .chose a {
            width: 100%;
        }
    }
</style>
</head>
<body>
<div class="all">
    <section class="sec1">
    <h1>Bienvenue dans votre espace Événements🎉🎊</h1>
    <p>Bienvenue dans votre espace de gestion d'événements. Un système complet qui vous permet de créer, organiser et suivre tous vos événements professionnels.</p>
    </section>
    <section class="sec2">
    <h2>Connexion</h2>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?>
        </div>
      <?php endif; ?>
    <form method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    <label for="password">Mot de passe:</label>
    <input type="password" name="mot_de_passe" required><br>
    <div class="chose">
      <input type="submit" value="Se connecter">
      <a href="inscription.php">Créer un compte</a>
    </div>
    </form>
    </section>
</div>
</body>
</html>
