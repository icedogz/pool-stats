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

if(isset($_GET['miner']) && $_GET['miner']!=""){

	$wallet = str_replace('0x', '', $_GET['miner']);
	$pool_url = "https://ethermine.org/api/miner_new/".$wallet;
	$bx_price_url = "https://bx.in.th/api/";
	$data = callService($pool_url,3);
	$bx_price = callService($bx_price_url,1);

	$balance = $data->unpaid/1000000000000000000;
	$next_payment_sec = (((float)($data->settings->minPayout/1000000000000000000)-$balance)/$data->ethPerMin)*60;
	$pay_in = new DateTime(date('Y-m-d H:i:s',time()+$next_payment_sec));
	$pay_in->setTimezone(new DateTimeZone('GMT+7'));
	$next_payment_minute = 'Next Payment : '.$pay_in->format('d M Y H:i'). ' ( '.convertToHoursMins($next_payment_sec/60, '%02d h %02d min ' ).')';

	$ret['wallet_address'] = $wallet;
	$ret['balance'] = number_format($balance,5). ' ETH';
	$ret['next_payment_minute'] = isset($data->settings->minPayout) ? $next_payment_minute : "";
	$ret['next_payment_in'] = number_format($data->unpaid/1000000000000000000,5). ' ETH';
	$ret['hashrates']['reported'] = $data->reportedHashRate;
	$ret['hashrates']['effective'] = $data->hashRate;
	$ret['hashrates']['average'] = number_format($data->avgHashrate/1000000,1).' MH/s';
	$ret['bx_price']['BTC']['price'] = number_format($bx_price->{1}->last_price,0).' THB';
	$ret['bx_price']['BTC']['change'] = $bx_price->{1}->change>0 ? '<span style="color:#44d844">(+'.$bx_price->{1}->change.'%)</span>' : '<span style="color:#ec2828">('.$bx_price->{1}->change.'%)</span>';
	$ret['bx_price']['ETH']['price'] = number_format($bx_price->{21}->last_price,0).' THB';
	$ret['bx_price']['ETH']['change'] = $bx_price->{21}->change>0 ? '<span style="color:#44d844">(+'.$bx_price->{21}->change.'%)</span>' : '<span style="color:#ec2828">('.$bx_price->{21}->change.'%)</span>';
	$ret['workers'] = $data->workers;
	$ret['earning']['day']['eth'] = number_format($data->ethPerMin*1440,2);
	$ret['earning']['day']['thb'] = number_format(($data->ethPerMin*1440) * $bx_price->{21}->last_price,2);
	$ret['earning']['week']['eth'] = number_format($data->ethPerMin*1440 * 7,2);
	$ret['earning']['week']['thb'] = number_format(($data->ethPerMin*1440) * $bx_price->{21}->last_price * 7,2);
	$ret['earning']['month']['eth'] = number_format($data->ethPerMin*1440 * 30,2);
	$ret['earning']['month']['thb'] = number_format(($data->ethPerMin*1440) * $bx_price->{21}->last_price * 30,2);

	$payouts = [];
	foreach ($data->payouts as $key => $pay) {
		if($key==9) break;
		$duration = "-";
		if(isset($data->payouts[$key+1]->paidOn)){
			$duration = strtotime($pay->paidOn) - strtotime($data->payouts[$key+1]->paidOn);
			$duration = number_format($duration/60/60,1).' Hr';
		}

		$d = new DateTime($pay->paidOn);
		$d->setTimezone(new DateTimeZone('GMT+7'));

		$payouts[$key]['date'] = $d->format('d M Y');
		$payouts[$key]['time'] = $d->format('H:i');
		$payouts[$key]['duration'] = $duration;
		$payouts[$key]['amount'] = number_format($pay->amount/1000000000000000000,5).' ETH';
		$payouts[$key]['tx'] = "https://etherchain.org/tx/".$pay->txHash;
	}

	$ret['payouts'] = $payouts;

	header('Content-Type: application/json');
	echo json_encode($ret);exit;
}


?>