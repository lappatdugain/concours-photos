<?php
    
function solutions_view($solutions, $equipment_name) {
    require('views/header.php');
    
    echo '<h2>Solutions pour le matériel ' . $equipment_name . '</h2>';
    foreach ($solutions as $sol) {
        
        echo '<section><h3>' . $sol['title'] . ' (saisie le ' . $sol['date'] . ")</h3>\n";
        echo '<p>' . $sol['text'] . "</p></section>\n";
        
    }
    
    require('views/footer.php');
 
}