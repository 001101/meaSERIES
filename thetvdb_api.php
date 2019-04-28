<?php

function tvdb_api($url) {
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
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer ".$token));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $json = curl_exec($ch);
   curl_close($ch);
   return json_decode($json, true);
}

?>

