<?php

include "../config.php";  

$jsonfile = '../series.json';
$inp = file_get_contents($jsonfile);

if ($inp != "") {
	$seriesarray = json_decode($inp, true);
	if ( $_GET["url"] == "" ) {
		echo '<!DOCTYPE html><html lang="en-US"><head><title>meaSERIES</title></head><body>'."\n";
		foreach ($seriesarray as $serie) {
			echo '<a href="'.$serie['title'].'/">'.urldecode($serie['title']).'</a>'."\n";
		}
		echo '</body></html>'."\n";
	} else {
		if (strpos($_GET["url"], '.mp4') !== false ) {
			preg_match('/(.*?)\/(.*?) - saison (.*?)\/(.*?) s(.*?)e(.*?).mp4/', $_GET["url"], $matches);
			foreach ($seriesarray as $serie) if ($serie['title'] == urlencode($matches[1])) {
				$episode = $serie['episodes'][$matches[3]][$matches[6]];
				if ( $episode['server'] == 'uptobox' ) {
					$url = "https://uptobox.com/api/link?token=".$uptobox_api_key."&file_code=".$episode['file_code'];
					$return = file_get_contents($url);
					$obj = json_decode($return, true);
					header("Location: ".$obj['data']['dlLink']);
				}
				if ( $episode['server'] == '1fichier' ) {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,"https://api.1fichier.com/v1/download/get_token.cgi");
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('url' => 'https://1fichier.com/?'.$episode['file_code'],'pretty' => '1')));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer '.$fichier_api_key]);
					$obj = json_decode(curl_exec ($ch), true);
					curl_close ($ch);
					print_r($obj); exit();
					header("Location: ".$obj['url']);
				}
			}
		} elseif (strpos($_GET["url"], ' - saison ') !== false ) {
			preg_match('/(.*?)\/(.*?) - saison (.*?)\//',$_GET["url"], $matches);
			echo '<!DOCTYPE html><html lang="en-US"><head><title>meaSERIES - '.urldecode($matches[2]).' - Saison '.$matches[3].'</title></head><body>'."\n";
			foreach ($seriesarray as $serie) if ($serie['title'] == urlencode($matches[2])) {
				foreach ($serie['episodes'][$matches[3]] as $episode => $value) {
					echo '<a href="'.$serie['title'].'+s'.$matches[3].'e'.$episode.'.mp4">'.urldecode($serie['title']).' s'.$matches[3].'e'.$episode.'.mp4</a>'."\n";
				}
			echo '</body></html>'."\n";
			}
		} else {
			foreach ($seriesarray as $serie) if ($serie['title'] == urlencode(rtrim($_GET["url"],"/"))) {
				echo '<!DOCTYPE html><html lang="en-US"><head><title>meaSERIES - '.urldecode($serie['title']).'</title></head><body>'."\n";
				foreach ($serie['episodes'] as $saison => $value) {
					echo '<a href="'.$serie['title'].'+-+saison+'.$saison.'/">'.urldecode($serie['title']).' - saison '.$saison.'</a>'."\n";
				}
				echo '</body></html>'."\n";
			}
		}
	}
}

?>
