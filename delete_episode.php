<?php

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

$serie = $_POST['serie'];
$saison = $_POST['saison'];
$episode = $_POST['episode'];

unset($tempArray[$serie]['episodes'][$saison][$episode]);

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./serie.php?id='.$serie); 

?>
