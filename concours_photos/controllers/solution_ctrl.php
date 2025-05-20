<?php

function solutions_list_ctrl() {
    require('models/connection.php');
    $c = connection();
    require('models/solution_crud.php');
    $id = $_GET['equ'];
    $solutions = find_solutions_by_equipment_id($c, $id);
    require('models/equipment_crud.php');
    $equipment = find_equipment($c, $id);
    $equipment_name = $equipment['name'];
    //View display
    require('views/solutions_view.php');
    solutions_view($solutions, $equipment_name);
}


