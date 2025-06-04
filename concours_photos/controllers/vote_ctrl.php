<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $photoId = intval($_POST['photoId']);

    if ($photoId) {
        $imagePath = "/var/www/dev/html/sae203-concoursphoto/stockage/$photoId.jpeg";
        var_dump($imagePath);

        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                echo "La photo $photoId a bien été supprimée , vous allez etre rediriger .";
      	  		header("Refresh: 1; URL=../index.php?route=vote_admin");
            } else {
                echo "Erreur lors de la suppression de la photo $photoId, vous allez etre rediriger .";
      	  		header("Refresh: 1; URL=../index.php?route=vote_admin");
                
            }
        } else {
            if ($photoId) {
                $imagePath = "/var/www/dev/html/sae203-concoursphoto/stockage/$photoId.jpg";
                var_dump($imagePath);
        
                if (file_exists($imagePath)) {
                    if (unlink($imagePath)) {
                        echo "La photo $photoId a bien été supprimée, vous allez etre rediriger .";
      	  		header("Refresh: 1; URL=../index.php?route=vote_admin");
                    } else {
                        echo "Erreur lors de la suppression de la photo $photoId.";
                    }
                } else {
                    if ($photoId) {
                        $imagePath = "/var/www/dev/html/sae203-concoursphoto/stockage/$photoId.jpeg";
                        var_dump($imagePath);
                
                        if (file_exists($imagePath)) {
                            if (unlink($imagePath)) {
                                echo "La photo $photoId a bien été supprimée, vous allez etre rediriger .";
      	  					header("Refresh: 1; URL=../index.php?route=vote_admin");
                            } else {
                                echo "Erreur lors de la suppression de la photo $photoId.";
                            }
                        } else {
                            echo "Pas de photo avec l'ID $photoId.";
                        }
                    }
                }
            }
        }
    } else {
        echo "Mauvais id de la photo.";
    }
} else {
    echo "Requête invalide.";
}