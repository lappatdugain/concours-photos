<?php
session_start();
require_once("php/db.php"); // connexion à la base

// Vérifie que tous les champs sont là
if (
    isset($_FILES['photo']) &&
    isset($_POST['id']) &&
    isset($_POST['titre']) &&
    isset($_POST['description'])
) {
    $user_id = htmlspecialchars($_POST['id']);
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);

    // Vérifie que les longueurs sont respectées
    if (strlen($titre) > 100 || strlen($description) > 300) {
        die("Titre ou description trop longue.");
    }

    // Récupération fichier
    $tmp_name = $_FILES['photo']['tmp_name'];
    $original_name = $_FILES['photo']['name'];
    $file_ext = pathinfo($original_name, PATHINFO_EXTENSION);
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($file_ext), $allowed_ext)) {
        $file_name = $user_id . "_" . time() . "." . $file_ext;
        $destination = "image_vote/" . $file_name;

        if (move_uploaded_file($tmp_name, $destination)) {
            // Insertion en BDD
            $sql = "INSERT INTO photos (id_utilisateur, titre, description, fichier) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $titre, $description, $file_name]);

            echo "Photo envoyée et enregistrée avec succès !";
        } else {
            echo "Erreur lors de l'enregistrement du fichier.";
        }
    } else {
        echo "Extension de fichier non autorisée.";
    }
} else {
    echo "Formulaire incomplet.";
}
?>

