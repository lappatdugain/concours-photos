<?php require('header.php') ?>

<div class="container mt-4">
    <h2>Déposer une photo</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?route=upload" method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label for="photo" class="form-label">Choisissez une photo :</label>
            <input type="file" class="form-control" name="photo" accept="image/jpeg,image/png" required>
            <small class="form-text text-muted">Formats acceptés : JPG, PNG. Taille maximale : 5MB</small>
        </div>

        <div class="mb-3">
            <label for="titre" class="form-label">Titre :</label>
            <input type="text" class="form-control" name="titre" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea class="form-control" name="description" maxlength="300" rows="3" 
                      placeholder="Veuillez entrer ici un court commentaire de votre photo..." required></textarea>
        </div>

        <div class="alert alert-info">
            <h5>Règles importantes :</h5>
            <ul>
                <li>La photo doit correspondre au thème du concours</li>
                <li>Le plagiat est strictement interdit</li>
                <li>L'utilisation d'IA est interdite</li>
                <li>Les retouches doivent être minimales</li>
                <li>La photo doit être nouvelle (pas de photo d'archive)</li>
            </ul>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <footer class="mt-4 text-muted">
        Date limite de dépôt : DD/MM/YYYY
    </footer>
</div>

<?php require('footer.php') ?>
