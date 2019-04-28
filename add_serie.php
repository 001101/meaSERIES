<?php

include ('functions.php');

$jsonfile = 'series.json';
if (!file_exists($jsonfile)) {
    $my_file = fopen($jsonfile, "w");
	fclose($my_file);
}

$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);
if ($tempArray == "") { $tempArray = [];}

$title = urlencode(strtolower(trim($_POST['title'])));

$json = tvdb_api('https://api.thetvdb.com/search/series?name='.urlencode(str_replace("'","",$_POST['title'])),'fr');
$serie_id = $json['data'][0]['id'];
	
if ( count($tempArray) != 0 ) {
	$findKey1 = search_revisions($tempArray, $title,'title');
	if ( count($findKey1) != 0 ) {
		include "./header.php"; 
		echo '<h1>Erreur</h1><br>';
		echo 'Cette série est déjà présente dans la base de données</br>';
		include("./footer.php");
		exit();
	}
}
$episodes = [];
$data = array('title' => $title, 'tvdb' => $serie_id, 'episodes' => $episodes);
array_push($tempArray, $data);
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);
header('Location: ./index.php');

?>
