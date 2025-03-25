<?php
include_once("../projet-QRcode/db.php");
session_start();

if(isset($_POST["verif"])) {
    if($_POST["verif"] == "register") {
        $name = trim($_POST["username"]);
        $password = $_POST["password"];
    
        if (!empty($name) && !empty($password)) {
            // Cryptage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Vérifier si l'admin existe déjà
            $sql = "SELECT username FROM admin WHERE username = :username";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $name, PDO::PARAM_STR);
            $stmt->execute();
    
            // Si un utilisateur est trouvé, rediriger vers index.html
            if($stmt->fetch()) {
                header("Location: index.html");
                exit(); // Arrêter le script après la redirection
            }
            
            // Stocker l'utilisateur
            // Écrire la requête d'insertion
            $sql = "INSERT INTO admin (username, password) VALUES (:username, :password)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':username', $name, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    
            // Exécuter la requête
            try {
                $stmt->execute(); 
                header("Location: index.html");
                exit(); // Toujours appeler exit après un header pour arrêter l'exécution du script
            } catch(Exception $e) {
                echo "Erreur lors de l'insertion : " . $e->getMessage();
            }
        } else {
            echo "Veuillez remplir les champs";
            return;
        }
    } 
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <style>
body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: rgb(0, 255, 98);
  color: brown;
}
.container {
  background-color: rgba(255, 255, 255, 0.7);
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
  width: 500px;
  max-width: 500px;
  text-align: center;
}
h1 {
  font-size: 20px;
  margin-bottom: 20px;
}
.form {
  display: flex;
  flex-direction: column;
  background-color: rgb(232, 232, 240);
  padding: 20px;
  border-radius: 20px;
  border: 2px solid rgba(255, 255, 255, 0.2);
}
input, button {
  padding: 15px;
  outline: none;
  border: 1px solid rgba(117, 47, 47, 0.2);
  background-color: transparent;
  color: #0c0c0c;
  margin-top: 10px;
  border-radius: 30px;
}
button {
  background-color: orange;
  color: black;
  font-weight: bold;
  cursor: pointer;
  transition: 0.6s;
}
button:hover {
  background-color: rgb(212, 174, 102);
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion Administrateur</h1>
        <form id="login-form" action="login.php" method="POST" class="form">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required aria-label="Nom d'utilisateur"><br><br>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required aria-label="Mot de passe"><br>
            <input type="hidden" value="register" name="verif">
            <button type="submit" value="envoyer">connecter</button>
        </form>
    </div>
</body>
</html>

