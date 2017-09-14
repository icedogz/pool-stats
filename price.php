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

$currency = isset($_GET['currency']) ? $_GET['currency'] : 'THB';
$coin_currency = isset($_GET['coin_currency']) ? $_GET['coin_currency'] : 'ETH';

if($currency=="THB" && $coin_currency=="ETH"){
	$bx_price = callService("https://bx.in.th/api/",1);
	$btc_price = $bx_price->{1}->last_price;
	$btc_price_change = $bx_price->{1}->change;
	$eth_price = $bx_price->{21}->last_price;
	$eth_price_change = $bx_price->{21}->change;
}else{
	$currency_field = strtolower($currency);
	$btc = callService('https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert='.$currency,3);
	$eth = callService('https://api.coinmarketcap.com/v1/ticker/ethereum/?convert='.$currency,3);
	$etc = callService('https://api.coinmarketcap.com/v1/ticker/ethereum-classic/?convert='.$currency,3);
	$btc_price = $btc[0]->{"price_".$currency_field};
	$btc_price_change = $btc[0]->percent_change_24h;
	$eth_price = $eth[0]->{"price_".$currency_field};
	$eth_price_change = $eth[0]->percent_change_24h;
	$etc_price = $etc[0]->{"price_".$currency_field};
	$etc_price_change = $etc[0]->percent_change_24h;
	$data['etc_price'] = (float)$etc_price ;
	$data['etc_price_change'] = $etc_price_change>0 ? '<span style="color:#44d844">(+'.$etc_price_change.'%)</span>' : '<span style="color:#ec2828">('.$etc_price_change.'%)</span>';
}

$data['btc_price'] = (float)$btc_price  ;
$data['btc_price_change'] = $btc_price_change>0 ? '<span style="color:#44d844">(+'.$btc_price_change.'%)</span>' : '<span style="color:#ec2828">('.$btc_price_change.'%)</span>';
$data['eth_price'] = (float)$eth_price ;
$data['eth_price_change'] = $eth_price_change>0 ? '<span style="color:#44d844">(+'.$eth_price_change.'%)</span>' : '<span style="color:#ec2828">('.$eth_price_change.'%)</span>';


header('Content-Type: application/json');
echo json_encode($data);exit;