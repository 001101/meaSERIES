<?php

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

$serie = $_GET['id'];

unset($tempArray[$serie]);

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./index.php'); 

?>
