<?php require('header_authen.php') ?>

  <article id="authen">
  <form action="../controllers/recherche_ldap_ctrl.php" method="post">
  <div id="login">
    <label for="login">Login : </label>
    <input type="email" name="login" id="login" required />
  </div>
  <div id="mdp">
    <label for="pass">Mot de Passe : </label>
    <input type="text" name="pass" id="mdp" required />
  </div>
  <div id="valider">
    <input type="submit" value="Valider" id="bouton"/>
  </div>
  </form>

<?php require('footer.php') ?>
