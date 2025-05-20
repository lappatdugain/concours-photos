<?php

/**
 * Switch to the appropriate controller according to HTTP method
 */
function add_equipment_ctrl() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        add_equipment_write_ctrl();
    } else {
        add_equipment_form_ctrl();
    }
}


/**
 * Form display
 */
function add_equipment_form_ctrl() {
    
    //Print form
    require('views/add_equipment_form_view.php');

}


/**
 * Form processing
 */
function add_equipment_write_ctrl() {
    // We read datas from form transmitted with POST method
    //var_dump($_POST);
    //exit;
    $name = $_POST['name'];
    $fam_id = $_POST['family'];
    
    // We write in database
    require('models/connection.php');
    $c = connection();
    require('models/equipment_crud.php');
    create_equipment($c, $name, $fam_id);
    
    // Done ! Go to welcome view
    require('views/welcome_view.php');
    
}
