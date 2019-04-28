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

include("./footer.php");

?>
