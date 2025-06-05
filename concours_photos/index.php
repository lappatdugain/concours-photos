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
            
        case 'family':
            require('controllers/family_ctrl.php');
            family_print_ctrl();
            break;
            
        case 'contact':
            require('views/contact_view.php');
            break;
            
        case 'solutions':
            require('controllers/solution_ctrl.php');
            solutions_list_ctrl();
            break;
            
        case 'vote':
            require('views/vote_view.php');
#            add_equipment_ctrl();
            break;
                       
        default:
            require('views/404_view.php');
            break;
            
    }
