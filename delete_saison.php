<?php

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

$serie = $_GET['serie'];
$saison = $_GET['saison'];

unset($tempArray[$serie]['episodes'][$saison]);

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./serie.php?id='.$serie); 

?>
