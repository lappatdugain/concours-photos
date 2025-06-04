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
        <p class="la-photo-cest">“La photographie, c'est mieux qu'un dessin, mais il ne faut pas le dire.”</p>
    </header>
    
    <div class="content">
        <?php
        foreach ($photoPaths as $photo) {
            echo '<div class="img-container">';
            echo '<img class="img-child" alt="Photo" src="'.$photo['path'].'">';
            echo '<p class="la-photo">' . htmlspecialchars($photo['title']) . '</p>';
            //echo '<button class="btn2" onclick="vote('.$photo['id_pro'].', \''.htmlspecialchars($photo['title']).'\')">💗</button>';
            echo '<button class="btn2" data-id="' . $photo['id'] . '" onclick="likePhoto(' . $photo['id_pro'] . ', \'' . htmlspecialchars($photo['title']) . '\')">💗</button>';

            require("modeles/SQLjs/vote_crud.php") ; 
            likePhoto($photo['id_pro'], $photo['title']);
            echo '</div>';
            echo '<br>';
        }
        ?>
        <button onclick="previousPage()">Précédent</button>
        <button onclick="nextPage()">Suivant</button>
    </div>
    <button onclick="confirmVote($user_id)">Confirmer le vote</button>
    <?php require("js/vote_photo.js") ; 
    confirmVote($user_id);

    ?>
    
    
</body>
</html>