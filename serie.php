<?php

include "./header.php";  
include "./functions.php";  

date_default_timezone_set('America/Montreal');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

$jsonfile = 'series.json';
$inp = file_get_contents($jsonfile);
$seriesarray = json_decode($inp, true);

echo '<table>';

if ( $seriesarray[$_GET['id']]['tvdb'] != "" ) {
	$array = tvdb_api('https://api.thetvdb.com/series/'.$seriesarray[$_GET['id']]['tvdb'],'fr');
	echo '<tr><td><h1>'.ucfirst(urldecode($seriesarray[$_GET['id']]['title'])).'</h1></td></tr>';
	echo '<tr><td><b>Première diffusion :</b> '.strftime('%e %B %Y', strtotime($array['data']['firstAired'])).'</td></tr>';
	$array2 = tvdb_api('https://api.thetvdb.com/series/'.$seriesarray[$_GET['id']]['tvdb'].'/images/query?keyType=poster','fr');
	if ( $array2['data'][0]['fileName'] == "" ) {
		$array2 = tvdb_api('https://api.thetvdb.com/series/'.$seriesarray[$_GET['id']]['tvdb'].'/images/query?keyType=poster','en');
	} 	
	echo '<tr><td><img class="cover" src="https://www.thetvdb.com/banners/'.$array2['data'][0]['fileName'].'">';
	$array2 = tvdb_api('https://api.thetvdb.com/series/'.$seriesarray[$_GET['id']]['tvdb'].'/images/query?keyType=fanart','fr');
	if ( $array2['data'][0]['fileName'] == "" ) {
		$array2 = tvdb_api('https://api.thetvdb.com/series/'.$seriesarray[$_GET['id']]['tvdb'].'/images/query?keyType=fanart','en');
	} 	
	echo '<img class="fanart" src="https://www.thetvdb.com/banners/'.$array2['data'][0]['fileName'].'"></td></tr>';
	echo '<tr><td>'.$array['data']['overview'].'</td></tr>';
}
	echo '<tr><td><h2>Éditer</h2><hr><br>';
echo '<form action="./update_serie.php" method="post"><b>Titre</b> <input type="hidden" name="id" value="'.$_GET['id'].'"> <input type="text" name="title" size="50" value="'.urldecode($seriesarray[$_GET['id']]['title']).'">&nbsp;&nbsp;&nbsp;&nbsp;';
if ( $seriesarray[$_GET['id']]['tvdb'] != "" ) {
	echo '<a href="https://www.thetvdb.com/search?q='.urldecode($seriesarray[$_GET['id']]['tvdb']).'&l=fr" target="tvdb">TVDB</a>';
} else {
	echo '<a href="https://www.thetvdb.com/search?q='.urldecode($seriesarray[$_GET['id']]['title']).'&l=fr" target="tvdb">TVDB</a>';
}
echo '&nbsp;<input type="text" name="tvdb" value="'.$seriesarray[$_GET['id']]['tvdb'].'" size="5" >';

echo '</a>&nbsp;&nbsp;&nbsp;&nbsp;<input id="submit" type="submit" name="submit" value="Modifier"></form>';

$nb_saison = 0;
foreach ( $seriesarray[$_GET['id']]['episodes'] as $key => $saison ) {
	echo '<hr>';
	echo '<h2>Saison '.$key.'</h2>';
	$nb_saison ++;
	$nb_episode = 0;
	$key2 = 0;
	foreach ( $seriesarray[$_GET['id']]['episodes'][$key] as $key2 => $episode ) {
		$nb_episode++;
		$url_file = "";
		if ( $episode['server'] == 'uptobox' ) { $url_file = 'https://www.uptobox.com/'.$episode['file_code']; }
		if ( $episode['server'] == '1fichier' ) { $url_file = 'https://www.1fichier.com/?'.$episode['file_code']; }
		echo '<form action="./update_episode.php" method="post"><b>Episode</b> <input type="hidden" name="serie" value="'.$_GET['id'].'"> <input type="hidden" name="saison" value="'.$key.'"> <input type="text" name="episode" value="'.$key2.'" size="2"> <input type="text" name="url_file" value="'.$url_file.'" size="50">&nbsp;&nbsp;<a href="'.$url_file.'" target="extern">';
		if ( $episode['active'] == 1 ) { echo '<img src="./good.png" class="icon" title="'.strftime('le %F à %T',$episode['last_check']).'">'; }
		if ( $episode['active'] == 0 ) { 
			if ( $episode['last_check'] == "" ) {
				echo '<img src="./unknow.png" class="icon">';
			} else {
				echo '<img src="./bad.png" class="icon" title="'.strftime('le %F à %T',$episode['last_check']).'">';
			}
		}  
		echo '</a>&nbsp;&nbsp;<input id="submit" type="submit" name="submit" value="Modifier / Vérifier"></form><form action="./delete_episode.php" method="post"> <input type="hidden" name="serie" value="'.$_GET['id'].'"> <input type="hidden" name="saison" value="'.$key.'"> <input type="hidden" name="episode" value="'.$key2.'"><input id="submit" type="submit" name="submit" value="Supprimer"></form>';
	}
	echo '<b>Ajouter l\'épisode</b>';
	echo '<form action="./add_episode.php" method="post"><input type="hidden" name="page" value="serie"><input type="hidden" name="serie" value="'.$_GET['id'].'"><input type="hidden" name="saison" value="'.$key.'"> <input type="text" placeholder="episode..." name="episode" value="'.($key2+1).'" size="2" > <input type="text" placeholder="URL uptobox ou 1fichier..." name="url_file" value="" size="50"> <input id="submit" type="submit" name="submit" value="Ajouter"></form></br>';
	if ( $nb_episode == 0 ) {
		echo '<b><a href="./delete_saison.php?saison='.$key.'&serie='.$_GET['id'].'" onclick="return confirm(\'Voulez-vous vraiment effacer cette saison?\');">supprimer la saison</a></b></br></br>';
	}
}
echo '<hr>';
echo '<b>Ajouter la saison</b> <form action="./add_saison.php" method="post"><input type="hidden" name="serie" value="'.$_GET['id'].'"><input type="text" name="saison" placeholder="saison..." value="'.($key+1).'" size="2"> <input id="submit" type="submit" name="submit" value="Ajouter"></form></br>';
if ( $nb_saison == 0 ) {
	echo '<hr><h2><a href="./delete_serie.php?id='.$_GET['id'].'" onclick="return confirm(\'Voulez-vous vraiment effacer cette série?\');">supprimer la série</a></h2></br></br>';
}
echo '</td></tr>';
echo '</table>';

include("./footer.php");

?>
