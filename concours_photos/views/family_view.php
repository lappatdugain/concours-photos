<?php

function family_view($equipments) {
    require('views/header.php');
    
    echo '<h2>Matériel de la famille</h2>
    <table>
	<tr><th>Nom du matériel</th><th>Nombre de solutions</th></tr>';
    
    foreach ($equipments as $equ) {
        echo '<tr><td>' . $equ['name'] . '</td><td>' . $equ['nb'] . '</td>';
        echo '<td><a href="index.php?route=solutions&equ=' . $equ['id'] . '">Afficher les solutions</a></td>';
        echo "</tr>\n";
    }
    
    echo '</table>';
    
    require('views/footer.php');
    
}