<?php

function callService($url,$cache=0){
	

    $cache_file = 'cache/'.md5($url);

    if (file_exists($cache_file) && $cache>0 && (filemtime($cache_file) > (time() - 60 * $cache ))) {
	 
	   $output = file_get_contents($cache_file);
	} else {
	  
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, $url);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	   $output = curl_exec($ch);
	   curl_close($ch);  
	   file_put_contents($cache_file, $output, LOCK_EX);
	}


    return  json_decode($output);    
}

$data = callService('https://api.coinmarketcap.com/v1/ticker/?convert=THB&limit=300',5);
header('Content-Type: application/json');
echo json_encode($data);exit;