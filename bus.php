<?php
1;2802;0cinclude_once("modele/function.php");



$URL = 'http://travelplanner.mobiliteit.lu/hafas/query.exe/dot?performLocating=2&tpl=stop2csv&stationProxy=yes&look_maxdist=150&look_x=6112550&look_y=49610700';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, '');
$resultat = curl_exec ($ch);
curl_close($ch);
$resultat = json_decode($resultat);
var_dump($resultat);

//$dataJ = my_get('http://travelplanner.mobiliteit.lu/hafas/query.exe/dot?performLocating=2&tpl=stop2csv&stationProxy=yes&look_maxdist=150&look_x=6112550&look_y=49610700');
//$dataJ = json_decode($dataJ);
?>
