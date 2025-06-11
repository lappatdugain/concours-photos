<?php
session_start();

function init_session() {
    if (!isset($_SESSION['initialized'])) {
        $_SESSION['initialized'] = true;
        $_SESSION['is_logged_in'] = false;
        $_SESSION['user_data'] = null;
    }
}

function login_user($login, $password) {
    require_once("recherche_ldap_crud.php");
    require_once("connection.php");
    
    // Vérification LDAP
    if (recherche_ldap($login, $password)) {
        $con = connection();
        
        // Récupération des données utilisateur depuis la base de données
        $req = "SELECT * FROM user WHERE id = :id";
        $prep = $con->prepare($req);
        $prep->bindValue(':id', $login);
        $prep->execute();
        $user = $prep->fetch(PDO::FETCH_ASSOC);
        $prep->closeCursor();

        if ($user) {
            // S'assurer que la session est démarrée
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['initialized'] = true;
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_data'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'prenom' => $user['prenom'],
                'admin' => $user['admin']
            ];
            return true;
        }
    }
    return false;
}

function logout_user() {
    $_SESSION['is_logged_in'] = false;
    $_SESSION['user_data'] = null;
    session_destroy();
}

function is_logged_in() {
    return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
}

function get_current_user() {
    if (!isset($_SESSION)) {
        return null;
    }
    if (!isset($_SESSION['user_data'])) {
        return null;
    }
    return $_SESSION['user_data'];
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: index.php?error=Vous devez être connecté pour accéder à cette page");
        exit;
    }
}

function require_admin() {
    require_login();
    $user = get_current_user();
    if (!$user || !$user['admin']) {
        header("Location: index.php?error=Vous n'avez pas les droits d'administrateur");
        exit;
    }
}

// Initialiser la session au chargement du fichier
init_session();
?>
