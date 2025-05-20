<?php
header('Status: 404 Not Found', true, 404);

require('views/header.php');

echo '<h2>Page introuvable !</h2>';

require('views/footer.php');
