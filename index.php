<?php

include "./header.php";  
include "./functions.php";  

echo '<h1>Ajouter une Série</h1><br>';
echo '<form action="./add_serie.php" method="post"><input type="text" placeholder="titre de la serie..." name="title" size="50" value=""> <input id="submit" type="submit" name="submit" value="Ajouter"></form></br>';

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
if ($inp != "") {

	$seriearray = json_decode($inp, true);
	$seriearray = array_reverse($seriearray, true);
#	$broken = 0;
#	foreach ($moviearray as $key => $movie) {
#		if ( $movie['active'] == 0 ) {
#			$broken++;
#		}
#	}
#
#	if ($broken != 0) {
#		echo '<h1>Films sans source</h1><br>';
#		foreach ($moviearray as $key => $movie) {
#			if ( $movie['active'] == 0 ) {
#				$json = json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$movie['tmdb'].'?api_key='.$tmdb_api_key.'&language=fr&append_to_response=trailers,credits'), true);
#				echo '<a href="./movie.php?id='.$key.'"><img title="'.ucfirst(urldecode($movie['title'])).' ('.$movie['year'].')" class="smallcover" src="http://image.tmdb.org/t/p/w154'.$json['poster_path'].'"></a>';
#			}
#		}
#	echo '<br><br>';
#	}
#
	$i = 0;
	echo '<h1>Les 50 dernières séries</h1><br>';
	foreach ($seriearray as $key => $serie) {
		$array = tvdb_api('https://api.thetvdb.com/series/'.$serie['tvdb'].'/images/query?keyType=poster','fr');
		if ( $array['data'][0]['fileName'] == "" ) {
			$array = tvdb_api('https://api.thetvdb.com/series/'.$serie['tvdb'].'/images/query?keyType=poster','en');
		} 
		echo '<a href="./serie.php?id='.$key.'"><img title="'.ucfirst(urldecode($serie['title'])).'" class="smallcover" src="https://www.thetvdb.com/banners/'.$array['data'][0]['fileName'].'"></a>';
		if(++$i > 50) break;
	}
}

	echo '<br><br><br><h1>Ajouter un épisode</h1><br>';
	echo '<form action="./add_episode.php" method="post"><select name="serie">';
	$seriearray = json_decode($inp, true);
	$seriearray = array_reverse($seriearray, true);
	foreach ($seriearray as $key => $serie) {
		echo '<option value="'.$key.'">'.ucfirst(urldecode($serie['title'])).'</option>';
	}
	echo '</select> <input type="text" placeholder="saison..." name="saison" size="4" value=""> <input type="text" placeholder="episode..." name="episode" value="" size="5" > <input type="text" placeholder="URL uptobox ou 1fichier..." name="url_file" value="" size="50"> <input id="submit" type="submit" name="submit" value="Ajouter"></form></br>';


include("./footer.php");

?>
