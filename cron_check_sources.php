<?php

include ('./functions.php');

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$tempArray = json_decode($inp, true);

foreach ($tempArray as $key => $serie) {
	foreach ($serie['episodes'] as $key2 => $saison) {
		foreach ($saison as $key3 => $episode) {
			if ( !isset($mini_time) ){ $mini_time = $episode['last_check']; }
			if ( !isset($server) ){ $server = $episode['server']; }
			if ( !isset($file_code) ){ $file_code = $episode['file_code']; }
			if ( !isset($mini_serie) ){ $mini_serie = $key; }
			if ( !isset($mini_saison) ){ $mini_saison = $key2; }
			if ( !isset($mini_episode) ){ $mini_episode = $key3; }
			if ($episode['last_check'] < $mini_time ) { 
				$mini_time = $episode['last_check'];
				$server = $episode['server'];
				$file_code = $episode['file_code'];
				$mini_serie = $key;
				$mini_saison = $key2;
				$mini_episode = $key3;
			}
		}
	}
}

echo  $mini_serie."".$mini_saison."".$mini_episode;
$check = check_source($server, $file_code);

$data = array('server' => $server,'file_code' => $file_code,'active' => $check[0],'last_check' => $check[1]);

$tempArray[$mini_serie]['episodes'][$mini_saison][$mini_episode] = $data;
$jsonData = json_encode($tempArray);
file_put_contents($jsonfile, $jsonData);

?>
