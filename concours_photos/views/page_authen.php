<?php require('header_authen.php') ?>

  <article id="authen">
  <form action="index.php?route=authentif" method="post">
  <div id="login">
    <label for="login">Login : </label>
    <input type="text" name="login" id="login" required />
  </div>
  <div id="mdp">
    <label for="pass">Mot de Passe : </label>
    <input type="password" name="pass" id="mdp" required />
  </div>
  <div id="valider">
    <input type="submit" value="Valider" id="bouton"/>
  </div>
  </form>

<?php require('footer.php') ?>
