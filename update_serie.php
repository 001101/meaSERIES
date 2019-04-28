<?php

include ('./functions.php');

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

$id = $_POST['id'];
$title = urlencode(strtolower(trim($_POST['title'])));
$tvdb = $_POST['tvdb'];

$tempArray[$id]['title'] = $title;
$tempArray[$id]['tvdb'] = $tvdb;
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./serie.php?id='.$id); 

?>
