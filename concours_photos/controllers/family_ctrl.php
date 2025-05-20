<?php

function families_list_ctrl() {
    require('models/connection.php');
    $c = connection();
    require('models/family_crud.php');
    $families = find_all_families($c);
    
    //View display
    require('views/families_view.php');
    families_view($families);
}


function family_print_ctrl() {
    require('models/connection.php');
    $c = connection();
    require('models/equipment_crud.php');
    $id = $_GET['id'];
    $equipments = find_equipments_by_family_id($c, $id);
    
    //View display
    require('views/family_view.php');
    family_view($equipments);
    
}
