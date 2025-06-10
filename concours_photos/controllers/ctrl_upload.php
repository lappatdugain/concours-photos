<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);
#require("modeles/vote_crud.php");
require_once("modeles/SQL/connection.php");
#require("modeles/SQL/recupID.php");
#require('modeles/SQL/close.php');


$con = connection(); // Récupère l'objet PDO depuis connection()

$sql = "INSERT INTO photos (id_utilisateur, titre, description, fichier) VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($sql); // Utilise $con ici
$stmt->execute([$user_id, $titre, $description, $file_name]);


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
            try {
                $sql = "INSERT INTO photos (id_utilisateur, titre, description, fichier) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($sql);
                $stmt->execute([$user_id, $titre, $description, $file_name]);
                echo "Photo envoyée et enregistrée avec succès !";
            } catch (PDOException $e) {
                echo "Erreur lors de l'insertion en BDD : " . $e->getMessage();
            }
            


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

function upload_photo() {
    // Vérification de la connexion
    if (!isset($_SESSION['id_user'])) {
        header("Location: index.php?error=Vous devez être connecté pour déposer une photo");
        exit;
    }

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
    $file_name = $_SESSION['id_user'] . "_" . time() . "." . $extension;
    $destination = "uploads/photos/" . $file_name;

    // Création du dossier d'upload s'il n'existe pas
    if (!file_exists("uploads/photos/")) {
        mkdir("uploads/photos/", 0777, true);
    }

    // Déplacement du fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        try {
            $con = connection();
            // Insertion en base de données
            $sql = "INSERT INTO photo (id_user, nom_photo, description, date_depot) 
                    VALUES (?, ?, ?, CURDATE())";
            $stmt = $con->prepare($sql);
            $stmt->execute([$_SESSION['id_user'], $titre, $description]);
            
            header("Location: index.php?success=Photo déposée avec succès");
            exit;
        } catch (PDOException $e) {
            // En cas d'erreur, supprimer le fichier uploadé
            if (file_exists($destination)) {
                unlink($destination);
            }
            header("Location: index.php?error=Erreur lors de l'enregistrement");
            exit;
        }
    } else {
        header("Location: index.php?route=upload&error=Erreur lors de l'upload du fichier");
        exit;
    }
}
?>

