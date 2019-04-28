<?php

include ('./functions.php');

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

$serie = $_POST['serie'];
$saison = $_POST['saison'];
$episode = $_POST['episode'];
$url = $_POST['url_file'];

$parts = parse_url($url);
$server = explode('.', str_replace('www.','',$parts['host']))[0];
$path = explode('/', str_replace('?','',$url));
$param = explode('&', $path[sizeof($path)-1]);
$check = check_source($server, $param[0]);

$data = array('server' => $server,'file_code' => $param[0],'active' => $check[0],'last_check' => $check[1]);

$tempArray[$serie]['episodes'][$saison][$episode] = $data;
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

header('Location: ./serie.php?id='.$serie); 

?>
