<?php

include_once("modele/function.php");

$URL = 'http://travelplanner.mobiliteit.lu/hafas/query.exe/dot?performLocating=2&tpl=stop2csv&look_maxdist=150000&look_x=6112550&look_y=49610700&stationProxy=yes';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, '');
$resultat = curl_exec ($ch);
curl_close($ch);
$l = 0;
$i = 0;
$elements = explode(";", $resultat);
foreach ($elements as $data)
{
  $ch2 = curl_init();
  if ($l)
  {
    $data = substr($data, 2,strlen($data) - 2);
  }
  if ($i == 50)
    exit(0);
  $URL = 'http://travelplanner.mobiliteit.lu/restproxy/departureBoard?accessId=cdt&format=json&'.$data;
  curl_setopt($ch2, CURLOPT_URL, $URL);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch2, CURLOPT_USERAGENT, '');
  $resultat = curl_exec ($ch2);
  curl_close($ch2);
  $resultat = json_decode($resultat);
  if (isset($resultat->{'Departure'}))
  {
    //echo "lol";
  var_dump($resultat);
  echo "<br />";
  echo "<br />";
  echo "<br />";
  echo "<br />";
  }
  $i++;
  $l = 1;
}
?>
