<?php

session_start();
require_once("php/db.php"); // connexion à la BDD

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    die("Utilisateur non connecté.");
}

$user_id = $_SESSION['id'];

// Vérifie qu’un fichier a été envoyé
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    $tmp_name = $_FILES['photo']['tmp_name'];
    $original_name = $_FILES['photo']['name'];
    $file_ext = pathinfo($original_name, PATHINFO_EXTENSION);

    // On vérifie si c’est bien une image
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($file_ext), $allowed_ext)) {
        $new_name = $user_id . "." . $file_ext; // nom = ID + extension
        $destination = "uploads/" . $new_name;

        // Déplace le fichier
        if (move_uploaded_file($tmp_name, $destination)) {
            echo "Photo envoyée avec succès !";

            

        } else {
            echo "Erreur lors de l'envoi.";
        }
    } else {
        echo "Le fichier doit être une image (.jpg, .png, .gif).";
    }
} else {
    echo "Aucun fichier envoyé ou erreur.";
}
?>

