<?php
    require('views/header.php');
?>
    
<h2>Ajout d'un nouveau matériel</h2>
<form action="index.php?route=add_equipment" method="post"> 
	<p><input type="text" size="100" maxlength="100" name="name" placeholder="nom de l'équipement" /></p>
	<p><input type="number" min="1" name="family" placeholder="numéro de la famille" /></p>
	<p><input type="submit" value="Enregistrer" /></p>
</form>

<?php
    require('views/footer.php');
