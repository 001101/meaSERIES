<?php

include ('functions.php');

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);
if ($tempArray == "") { $tempArray = [];}

$id = $_POST['serie'];
$saison = $_POST['saison'];

$tempArray[$id]['episodes'][$saison] = array();
ksort($tempArray[$id]['episodes']);

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);
header('Location: ./serie.php?id='.$id);

?>
