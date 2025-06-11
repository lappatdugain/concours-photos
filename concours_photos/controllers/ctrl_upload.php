<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);
#require("modeles/vote_crud.php");
require_once("models/connection.php");
require_once("models/upload_crud.php");
require_once("models/session_manager.php");

// Vérifier si l'utilisateur est connecté
require_login();

$con = connection();
$user = get_current_user();

// Vérifie que tous les champs sont là
if (
    isset($_FILES['photo']) &&
    isset($_POST['titre']) &&
    isset($_POST['description'])
) {
    $user_id = $user['id'];
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);

    // Vérifie que les longueurs sont respectées
    if (strlen($titre) > 100 || strlen($description) > 300) {
        header("Location: index.php?error=Titre ou description trop longue");
        exit;
    }

    // Vérifie si l'utilisateur a déjà uploadé une photo
    if (has_user_uploaded($con, $user_id)) {
        header("Location: index.php?error=Vous avez déjà uploadé une photo");
        exit;
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
            // Insertion en BDD via le CRUD
            if (upload_photo($con, $user_id, $titre, $description)) {
                header("Location: index.php?success=Photo envoyée et enregistrée avec succès");
                exit;
            } else {
                header("Location: index.php?error=Erreur lors de l'insertion en BDD");
                exit;
            }
        } else {
            header("Location: index.php?error=Erreur lors de l'enregistrement du fichier");
            exit;
        }
    } else {
        header("Location: index.php?error=Extension de fichier non autorisée");
        exit;
    }
} else {
    header("Location: index.php?error=Formulaire incomplet");
    exit;
}

function upload_photo() {
    // Vérification de la connexion
    require_login();
    $user = get_current_user();

    // Vérification des données du formulaire
    if (!isset($_FILES['photo']) || !isset($_POST['titre']) || !isset($_POST['description'])) {
        header("Location: index.php?route=upload&error=Formulaire incomplet");
        exit;
    }

    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);

    // Validation des longueurs
    if (strlen($titre) > 30 || strlen($description) > 300) {
        header("Location: index.php?route=upload&error=Titre ou description trop longue");
        exit;
    }

    // Traitement de la photo
    $file = $_FILES['photo'];
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        header("Location: index.php?route=upload&error=Format de fichier non autorisé");
        exit;
    }

    if ($file['size'] > $max_size) {
        header("Location: index.php?route=upload&error=La taille du fichier ne doit pas dépasser 5MB");
        exit;
    }

    // Génération du nom de fichier unique
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name = $user['id'] . "_" . time() . "." . $extension;
    $destination = "uploads/photos/" . $file_name;

    // Création du dossier d'upload s'il n'existe pas
    if (!file_exists("uploads/photos/")) {
        mkdir("uploads/photos/", 0777, true);
    }

    // Déplacement du fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $con = connection();
        
        // Insertion en base de données via le CRUD
        if (upload_photo($con, $user['id'], $titre, $description)) {
            header("Location: accueil.php?success=Photo déposée avec succès");
            exit;
        } else {
            // En cas d'erreur, supprimer le fichier uploadé
            if (file_exists($destination)) {
                unlink($destination);
            }
            header("Location: accueil.php?error=Erreur lors de l'enregistrement");
            exit;
        }
    } else {
        header("Location: index.php?route=upload&error=Erreur lors de l'upload du fichier");
        exit;
    }
}
?>
