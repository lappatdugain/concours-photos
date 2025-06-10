<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 1);
#require("modeles/vote_crud.php");
#require("modeles/SQL/connection.php");
#require("modeles/SQL/recupID.php");
#require('modeles/SQL/close.php');

$con = connection();

$user_id = find_id_user($con);

// Appel de la fonction pour récupérer les IDs et les titres
$photos = get_photos($con);

// Dossier où les images sont stockées
$storage_dir = 'stockage/';

// Génération des chemins d'accès aux images et vérification de l'existence des fichiers
$photoPaths = [];
foreach ($photos as $photo) {
    $file_path = $storage_dir . $photo['id_proprietaire'] . '.jpeg';
    if (file_exists($file_path)) {
        $photoPaths[] = [
            'path' => $file_path,
            'id_pro' => $photo['id_proprietaire'],
            'title' => $photo['titre']
        ];
    } else {
        // Debugging: log file path if not found
        error_log("File not found: " . $file_path);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <link rel="stylesheet" href="css/voter.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,700;1,900&display=swap" />
    <title>Voter</title>
</head>
<body>
    <header class="header">
        <h1 class="voter-admin">Voter - Concours photo</h1>
    </header>
    
    <div class="grid-box">
        <?php
        $photoPaths = scandir("./nomDossier");
        foreach ($photoPaths as $photo) {
            echo '<div class="grid-images" data-modal="modal-"' . $photo['id_user'] . '" onclick="openImg(event)">';
            echo '<img src="' . $photo['path'] . '">';
            echo '<div class="txt-images">';
            echo '<p>' .$photo['nom_photo']. '</p>';
            echo '<input type="button" value="voter" onclick="openImg(event)">';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <?php
    foreach ($photoPaths as $photo) {
        echo '<div class="modal modal"' . $photo['id_user'] . '">';
        echo '<div class="modal-box">';
        echo '<span class="close" onclick="closeImg(this)">&times;</span>';
        echo '<img src="' . $photo['path'] . '">';
        echo '<p>' .$photo['nom_photo']. '</p>';
        echo '<p class="txt-images">' .$photo['description']. '</p>';     
        echo '</div></div>';
    }
    ?>
    
    
</body>
</html>