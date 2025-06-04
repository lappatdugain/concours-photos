<?php require('header.php') ?>

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

    <label for="titre">Titre </label>
    <input type="text" name="titre" maxlength="100" required>

    <label for="description">Description </label>
    <textarea name="description" maxlength="300" placeholder="Veuillez entrer ici un court commentaire de votre photo...." required></textarea>

        <button type="submit">Envoyer</button>
    </form>
    <footer>
            Date limite de dépôt : DD/MM/YYYY
    </footer>
</body>
</html>
