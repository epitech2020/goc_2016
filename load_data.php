<?php

include('modele/connexion_sql.php');

$list_station = file_get_contents('https://developer.jcdecaux.com/rest/vls/stations/Luxembourg.json');
var_dump(json_decode($list_station));
//$rep = $bdd->prepare()

?>
