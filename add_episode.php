<?php

include ('functions.php');

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);
if ($tempArray == "") { $tempArray = [];}

$id = $_POST['serie'];
$referer = $_POST['page'];
$saison = $_POST['saison'];
$episode = $_POST['episode'];
$url = $_POST['url_file'];

$parts = parse_url($url);
$server = explode('.', str_replace('www.','',$parts['host']))[0];
$path = explode('/', str_replace('?','',$url));
$param = explode('&', $path[sizeof($path)-1]);
$check = check_source($server, $param[0]);
$episode_data = array('server' => $server,'file_code' => $param[0],'active' => $check[0],'last_check' => $check[1]);
$tempArray[$id]['episodes'][$saison][$episode] = $episode_data;
ksort($tempArray[$id]['episodes'][$saison]);

$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

if ( $referer == 'serie') {
	header('Location: ./serie.php?id='.$id);
} else {
	header('Location: ./index.php');
}

?>
