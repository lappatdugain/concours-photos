<?php
function recherche_ldap_ctrl() {
  define('SERVER', 'ldaps://ldapsupannappli.univ-poitiers.fr:636');
  define('ROOT', 'ou=people,dc=univ-poitiers,dc=fr');
    $login = $_POST['login'];
    $pass = $_POST['pass'];
  
    require('models/recherche_ldap.crud.php');
    recherche_ldap($login, $pass);
    

    require('views/welcome_view.php');
    
}
