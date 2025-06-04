<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
//ini_set('display_errors', 1);
// V. Verdon 20240607
// Vérifie si le compte existe dans le LDAP de l'Université
//Attention, on a besoin d'installer le paquet php-ldap pour que cela fonctionne !
function recherche_ldap($login,$pass) {
// Configuration pour l'interface PHP du LDAP
define('SERVER', 'ldaps://ldapsupannappli.univ-poitiers.fr:636');
define('ROOT', 'ou=people,dc=univ-poitiers,dc=fr');

// Initialisation de la connexion LDAP
$connex=ldap_connect(SERVER);
ldap_set_option($connex, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($connex) {
	// on se connecte anonymement dans un premier temps afin de trouver l'uid correspondant au login
    ldap_bind($connex);
    //on recherche l'uid correspondant au login'
    $req = 'supannAliasLogin=' . $login;
    $res = ldap_search($connex, ROOT, $req);
	$datas = ldap_get_entries($connex, $res);
    if ($datas) {
        $uid = $datas[0]['uid'][0];
        // on se connecte maintenant avec l'uid récupéré de l'utilisateur et on vérifie si la requête aboutit
    $dn = 'uid=' . $uid . ',' . ROOT;
	if (ldap_bind($connex,$dn,$pass)) {
        echo "<p>COMPTE EXISTANT</p>";
    // Récup du prénom et du nom
    //sn = nom
    //givenname = prénom
    $prenom = $datas[0]['givenname'][0];
    $nom = $datas[0]['sn'][0];
    echo "<p>Prénom = $prenom ; Nom = $nom </p>";
        } else {
            echo "<p>PAS DE COMPTE</p>";
        }
    }
    
    //Fermeture de la connexion LDAP
	ldap_close($connex);
	
}
else {
	echo "Impossible de se connecter au serveur LDAP\n";
}
}
?>
