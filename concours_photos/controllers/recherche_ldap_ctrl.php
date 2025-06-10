<?php
function recherche_ldap_ctrl() {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
  
    require('./models/recherche_ldap_crud.php');
    recherche_ldap($login, $pass);
    
    // We write in database
    require('models/connection.php');
    $c = connection();

    bdd_compte($c, $login, $pass);
    
    require('views/accueil.php');
    
}
