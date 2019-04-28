<?php

include ('functions.php');

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);
if ($tempArray == "") { $tempArray = [];}

$id = $_POST['serie'];
$saison = $_POST['saison'];
$episode = $_POST['episode'];
$url = $_POST['url_file'];

$parts = parse_url($url);
$server = explode('.', str_replace('www.','',$parts['host']))[0];
$path = explode('/', str_replace('?','',$url));
$param = explode('&', $path[sizeof($path)-1]);
$check = check_source($server, $param[0]);
	
#if ( count($tempArray) != 0 ) {
#	$findKey1 = search_revisions($tempArray, $title,'title');
#	if ( count($findKey1) != 0 ) {
#		include "./header.php"; 
#		echo '<h1>Erreur</h1><br>';
#		echo 'Cette série est déjà présente dans la base de données</br>';
#		include("./footer.php");
#		exit();
#	}
#}

#$episode_data = array('saison' => $saison,'episode' => $episode, 'server' => $server,'file_code' => $param[0],'active' => $check[0],'last_check' => $check[1]);
#array_push($tempArray[$id]['episodes'], $episode_data);

$episode_data = array('server' => $server,'file_code' => $param[0],'active' => $check[0],'last_check' => $check[1]);
$tempArray[$id]['episodes'][$saison][$episode] = $episode_data;

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);
header('Location: ./index.php');

?>
