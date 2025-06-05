<?php
function recherche_ldap_ctrl() {
    $login = $_POST['login'];
    $pass = $_POST['pass'];
  
    require('models/recherche_ldap.crud.php');
    recherche_ldap($login, $pass);
    

    require('views/welcome_view.php');
    
}
