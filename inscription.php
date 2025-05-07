<?php
require('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $email, $mot_de_passe]);
        $cree = "Utilisateur inscrit. <a href='connexion.php'>Connectez-vous</a>";
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $erreur = "Cet email est déjà utilisé. Veuillez utiliser un autre email.";
        } else {
            $erreur = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    display: flex;
    width: 100%;
    max-width: 1100px;
    margin: 20px auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    flex-wrap: wrap;
}

/* Section gauche */
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
    border-radius: 22px 0 0 22px;
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

.sec1 ul {
    list-style-type: none;
    padding-left: 0;
    margin-top: 30px;
}

.sec1 ul li {
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

.sec1 ul li strong {
    font-size: 1.2rem;
    display: block;
    margin-bottom: 5px;
}

/* Section droite */
.sec2 {
    width: 50%;
    padding: 50px 40px;
    background-color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    border-radius: 0 22px 22px 0;
}

.sec2 header {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
}

.sec2 header h2 {
    text-align: center;
    margin: 0 auto;
    font-size: 2rem;
    color: #2d3748;
    font-weight: 700;
}

.sec2 header a {
    font-size: 1.8rem;
    color: #3e4b58;
    transition: all 0.3s ease;
    text-decoration: none;
}

.sec2 header a:hover {
    color: #11212d;
    transform: translateX(-3px);
}

/* Formulaire */
form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #4a5568;
    font-size: 1rem;
}

form input[type="text"],
form input[type="email"],
form input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    font-size: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.3s ease;
    background-color: #f8fafc;
    margin-bottom: 20px;
}

form input:focus {
    outline: none;
    border-color: #3e4b58;
    box-shadow: 0 0 0 3px rgba(62, 75, 88, 0.1);
    background-color: white;
}

.chose {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 10px;
}

.chose input[type="submit"] {
    background-color: #3e4b58;
    color: white;
    padding: 14px;
    font-size: 1rem;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chose input[type="submit"]:hover {
    background-color: #11212d;
    transform: translateY(-2px);
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-top: 20px;
    background-color: #fff5f5;
    color: #c53030;
    font-weight: 500;
    border-left: 4px solid #c53030;
}

/* Responsive */
@media (max-width: 900px) {
    .all {
        flex-direction: column;
        max-width: 500px;
    }

    .sec1,
    .sec2 {
        width: 100%;
        padding: 40px 30px;
    }

    .sec1::before {
        border-radius: 22px 22px 0 0;
    }

    .sec2 {
        border-radius: 0 0 22px 22px;
    }
}

@media (max-width: 480px) {
    .sec1 h1 {
        font-size: 2rem;
    }

    .sec2 h2 {
        font-size: 1.5rem;
    }

    .sec2 header {
        flex-direction: column;
        gap: 10px;
    }

    .sec2 header a {
        align-self: flex-start;
    }
}
</style>
</head>
<body>
    <div class="all">
    <section class="sec1">
    <h1>Créez votre compte gratuit</h1>
    <p>Découvrez nos fonctionnalités clés pour organisateurs et agences</p>
    <ul style="list-style-type: none; padding-left: 0;">
      <li style="margin-bottom: 1.5rem;">
        <strong>🎪 Assistant de création d'événements</strong><br>
        Configurez rapidement des événements professionnels avec notre guide pas à pas.
      </li>
  
      <li style="margin-bottom: 1.5rem;">
        <strong>♾️ Événements illimités</strong><br>
        Gérez autant d'événements que vous voulez, des petites réunions aux grandes conférences.
      </li>
    </ul>
    </section>
    <section class="sec2">
      <header>
        <a href="connexion.php">
            <i class="fa-solid fa-circle-chevron-left"></i>
        </a>
        <h2>Inscription</h2>
      </header>
      <form method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="pass">Password</label>
        <input type="password" name="mot_de_passe" required><br>
        <div class="chose">
          <input type="submit" value="Créer">
        </div>
      </form>
      <?php if (isset($cree)): ?>
          <div class="alert alert-success">
            <?= $cree ?>
          </div>
        <?php endif; ?>
        <?php if (isset($erreur)): ?>
          <div class="alert alert-danger">
            <?= $erreur ?>
          </div>
        <?php endif; ?>
    </section>
    </div>
</body>
</html>