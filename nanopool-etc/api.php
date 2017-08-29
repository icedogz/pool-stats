<?php
function convertToHoursMins($time, $format = '%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
function callService($url,$cache=0){
	

    $cache_file = '../cache/'.md5($url);

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

if(isset($_GET['miner']) && $_GET['miner']!=""){

	$wallet = str_replace('0x', '', $_GET['miner']);
	$pool_url = "https://api.nanopool.org/v1/etc/user/".$wallet;
	$bx_price_url = "https://bx.in.th/api/";
	$data = callService($pool_url,3);
	$data = $data->data;
	$payments = callService('https://api.nanopool.org/v1/etc/payments/'.$wallet,3);
	$earning = callService('https://api.nanopool.org/v1/etc/approximated_earnings/'.$data->avgHashrate->h6,3);

	$currency_field = strtolower($currency);
	$btc = callService('https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert='.$currency,3);
	$etc = callService('https://api.coinmarketcap.com/v1/ticker/ethereum-classic/?convert='.$currency,3);
	$btc_price = $btc[0]->{"price_".$currency_field};
	$btc_price_change = $btc[0]->percent_change_24h;
	$etc_price = $etc[0]->{"price_".$currency_field};
	$etc_price_change = $etc[0]->percent_change_24h;

	$balance = $data->balance;
	$ret['wallet_address'] = $wallet;
	$ret['balance'] = number_format($balance,5). ' ETC';
	$ret['next_payment_minute'] = "";
	$ret['next_payment_in'] = "";
	$ret['hashrates']['reported'] = number_format($data->hashrate,1) .' MH/s';
	$ret['hashrates']['effective'] = number_format($data->avgHashrate->h1,1) .' MH/s';
	$ret['hashrates']['average'] = number_format($data->avgHashrate->h6,1).' MH/s';
	$ret['bx_price']['BTC']['price'] = number_format($btc_price,0).' '.$currency;
	$ret['bx_price']['BTC']['change'] = $btc_price_change>0 ? '<span style="color:#44d844">(+'.$btc_price_change.'%)</span>' : '<span style="color:#ec2828">('.$btc_price_change.'%)</span>';
	$ret['bx_price']['ETH']['price'] = number_format($etc_price,0).' '.$currency;
	$ret['bx_price']['ETH']['change'] = $etc_price_change>0 ? '<span style="color:#44d844">(+'.$etc_price_change.'%)</span>' : '<span style="color:#ec2828">('.$etc_price_change.'%)</span>';

	$workers = [];
	foreach ($data->workers as $key => $worker) {
		$workers[$key] = [
			'worker' => $worker->id,
			'reportedHashRate' => $worker->hashrate,
			'hashrate' => isset($worker->avg_h1) ? $worker->avg_h1 : 0,
			'validShares' => '',
			'staleShares' => '',
			'invalidShares' => '',
		];
	}

	$ret['workers'] = $workers;
	$ret['earning']['day']['eth'] = number_format($earning->data->minute->coins*1440,2);
	$ret['earning']['day']['thb'] = number_format(($earning->data->minute->coins*1440) * $etc_price,2);
	$ret['earning']['week']['eth'] = number_format($earning->data->minute->coins*1440 * 7,2);
	$ret['earning']['week']['thb'] = number_format(($earning->data->minute->coins*1440) * $etc_price * 7,2);
	$ret['earning']['month']['eth'] = number_format($earning->data->minute->coins*1440 * 30,2);
	$ret['earning']['month']['thb'] = number_format(($earning->data->minute->coins*1440) * $etc_price * 30,2);

	$payouts = [];
	foreach ($payments->data as $key => $pay) {
		if($key==9) break;
		$duration = "-";
		if(isset($payments->data[$key+1]->date)){
			$duration = $pay->date - $payments->data[$key+1]->date;
			$duration = number_format($duration/60/60,1).' Hr';
		}

		$d = new DateTime(date('Y-m-d H:i:s',$pay->date));
		$d->setTimezone(new DateTimeZone('GMT+7'));

		$payouts[$key]['date'] = $d->format('d M y');
		$payouts[$key]['time'] = $d->format('H:i');
		$payouts[$key]['duration'] = $duration;
		$payouts[$key]['amount'] = number_format($pay->amount,5).' ETC';
		$payouts[$key]['tx'] = $pay->txHash;
	}

	$ret['payouts'] = $payouts;

	header('Content-Type: application/json');
	echo json_encode($ret);exit;
}


?>