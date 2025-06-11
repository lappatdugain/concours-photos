<?php
    //The front root controller
    
    //SEULEMENT en phase de développement !
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set('display_errors', 1);
    
    //The requested route
    $route = null;
    if (isset($_GET['route'])) {
        $route = $_GET['route'];
    }
    
    //We switch to the good controller
    switch ($route) {
        case null:
            require('views/page_authen.php');
            break;
            
        case 'authentif':
            require('controllers/recherche_ldap_ctrl.php');
            recherche_ldap_ctrl();
            break;
                    
        case 'vote':
            require('views/vote_view.php');
#            add_equipment_ctrl();
            break;

        case 'upload':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require('controllers/ctrl_upload.php');
                upload_photo();
            } else {
                require('views/view_upload.php');
            }
            break;
                       
        default:
            require('views/404_view.php');
            break;
            
    }
