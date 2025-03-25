<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qr_code_data";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qrId = isset($_POST['qr_id']) ? htmlspecialchars($_POST['qr_id']) : '';
    $action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : '';
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : '';
    $time = isset($_POST['time']) ? htmlspecialchars($_POST['time']) : '';

    // Ajouter des messages de débogage
    echo "Requête POST reçue.<br>";
    echo "QR ID: " . $qrId . "<br>";
    echo "Action: " . $action . "<br>";
    echo "Nom: " . $name . "<br>";
    echo "Date: " . $date . "<br>";
    echo "Heure: " . $time . "<br>";

    if (!empty($qrId) && !empty($action) && !empty($name) && !empty($date) && !empty($time)) {
        $stmt = $conn->prepare("INSERT INTO scans (qr_id, action, name, date, time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $qrId, $action, $name, $date, $time);

        if ($stmt->execute()) {
            echo "Données enregistrées avec succès !<br>";
        } else {
            echo "Erreur d'exécution: " . $stmt->error . "<br>";
        }

        $stmt->close();
    } else {
        echo "QR Code ID, Action, Nom, Date ou Heure manquant.<br>";
    }
} else {
    echo "Méthode de requête non autorisée.<br>";
}

$conn->close();
?>
