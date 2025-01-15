<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez et récupérez les données de la requête POST
    $qrId = isset($_POST['qr_id']) ? htmlspecialchars($_POST['qr_id']) : '';
    $action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : '';

    // Processus selon l'action déterminée
    if (!empty($qrId) && !empty($action)) {
        // Ajouter votre logique de traitement ici
        echo "QR Code ID: " . $qrId . "<br>";
        echo "Action: " . $action;
    } else {
        echo "QR Code ID ou Action manquant.";
    }
} else {
    echo "Méthode de requête non autorisée.";
}
?>
