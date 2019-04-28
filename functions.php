<?php

function search_revisions($dataArray, $search_value, $key_to_search, $other_matching_value = null, $other_matching_key = null) {
    $keys = array();
    foreach ($dataArray as $key => $cur_value) {
        if ($cur_value[$key_to_search] == $search_value) {
            if (isset($other_matching_key) && isset($other_matching_value)) {
                if ($cur_value[$other_matching_key] == $other_matching_value) {
                    $keys[] = $key;
                }
            } else {
                $keys[] = $key;
            }
        }
    }
    return $keys;
}

function tvdb_api($url,$lang) {
   $postfields = json_encode(array('apikey' => 'MZGSX1NBVNO2FS7E', 'userkey' => 'J51KLH5QLXBWZAAC', 'username' => 'angelscry743qy'));
   $urlquery = 'https://api.thetvdb.com/login?'.$postfields;

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
   curl_setopt($ch, CURLOPT_URL, 'https://api.thetvdb.com/login?');
   curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $json = curl_exec($ch);
   curl_close($ch);
   $token = json_decode($json, true)['token'];

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept-Language: '.$lang, "Authorization: Bearer ".$token));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $json = curl_exec($ch);
   curl_close($ch);
   return json_decode($json, true);
}

function check_source($server, $file_code) {
	include ('./config.php');
	$active = 0;
	$last_check = time();
	if ($server == 'uptobox') {
		$url = "https://uptobox.com/api/link?token=".$uptobox_api_key."&file_code=".$file_code;
		$return = @file_get_contents($url);
		$obj = json_decode($return, true);
		if ($obj['statusCode'] == 0 ) { $active = 1; }
	} 
	if ($server == '1fichier') {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.1fichier.com/v1/download/get_token.cgi");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('url' => 'https://1fichier.com/?'.$file_code,'pretty' => '1')));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer '.$fichier_api_key]);
		$obj = json_decode(curl_exec ($ch), true);
		curl_close ($ch);
		if ($obj['status'] == 'OK' ) { $active = 1; }
	}
	return array($active, $last_check);
}
?>
