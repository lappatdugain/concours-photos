<?php

session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dépôt de photo</title>
</head>
<body>
    <h2>Déposer une photo</h2>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="photo">Choisissez une photo :</label>
        <input type="file" name="photo" accept="image/*" required><br><br>

        <button type="submit">Envoyer</button>
    </form>
    <footer>
            Date limite de dépôt : DD/MM/YYYY
    </footer>
</body>
</html>
