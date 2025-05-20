<?php

function families_view($families) {
    require('views/header.php');
    
    echo '<h2>Familles de matériels présentes dans la base</h2>';
    echo '<ul>';
    
    foreach ($families as $fam) {
        echo '<li><a href="index.php?route=family&id=' . $fam['id'] . '">' . $fam['name'] . "</a></li>\n";
    }
    
    echo '</ul>';
    
    require('views/footer.php');
}
