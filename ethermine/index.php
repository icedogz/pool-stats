<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Pool Stats </title>

	
		
	

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
	<link rel="manifest" href="favicons/manifest.json">
	<meta name="theme-color" content="#111111">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<style type="text/css">
		body{background: #111; color:#a6e22e; font-size:12px; }
		a{color:#e6db74; }
		.panel-body{padding:10px;}
		.panel{background: #222; }
		.panel-heading{background: #444; font-weight: bold; color:#999; font-size:13px;padding:5px; }
		.container{max-width: 600px; }
		hr,.table>tbody>tr>td, .table>tbody>tr>th{border-color: #444; }
		.table>thead>tr>th{border-color: #444; }
		.label{color:#999;font-size:12px; }
		.form-control{border-radius: 0; background: #222; color:#a6e22e; border-color:#a6e22e }
		.form-control:focus{box-shadow: none !important; border-color:#a6e22e !important; }
		.btn{background: #222;color:#999; }
		.btn:hover,.btn:focus,.btn:active{background: #252525;color:#999; }
	</style>
</head>
<body>
	<div class="container">

		<div class="row">
			<?php if(isset($_GET['miner']) && $_GET['miner']!=""){ ?>
			<div class="col-xs-12">
				<h5 style="overflow: hidden;margin-top:20px;text-align: center;" id="walletaddress"><img width="15" src="default.svg"></h5>
				
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="panel ">
						  <div class="panel-heading">Unpaid Balance</div>
						  <div class="panel-body text-center">
						  	<div class="row">
						  		<div class="col-xs-12">
						  		<h4 style="margin:0" id="balance"><img width="20" src="default.svg"></h4>
						  		<span id="next-payment" style="font-size:11px;"></span>
						  		</div>
						  	
						  	</div>
						  </div>
						</div>
					</div>
					
					<div class="col-md-12 text-center">
						<div class="panel">
						  <div class="panel-heading">Hashrates</div>
						  <div class="panel-body">
						  	<div class="row">
						  		<div class="col-xs-4"><h5 style="margin:0" id="reported-hashrate"><img width="15" src="default.svg"></h5><span class="label">Reported</span></div>
						  		<div class="col-xs-4"><h5 style="margin:0" id="effective-hashrate"><img width="15" src="default.svg"></h5><span class="label">Effective</span></div>
						  		<div class="col-xs-4"><h5 style="margin:0" id="average-hashrate"><img width="15" src="default.svg"></h5><span class="label">Average</span></div>
						  	</div>
						    
						  </div>
						</div>
					</div>
					
					<div class="col-md-12 text-center">
						<div class="panel">
						  <div class="panel-heading">BX Prices</div>
						  <div class="panel-body">
							  <div class="col-xs-6"><h5 style="margin:0" id="btc-price"><img width="18" src="default.svg"></h5>
							  <span class="label">BTC
							  	<span id="btc-change"> </span>
							  </span>
							  </div>
							  <div class="col-xs-6"><h5 style="margin:0" id="eth-price"><img width="18" src="default.svg"></h5><span class="label">ETH
								  <span id="eth-change"></span>
							  </span>
							  </div>
						  
						  </div>
						</div>
					</div>
				</div>
		
			
				<h4>Workers</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Worker</th>
							<th>Reported</th>
							<th>Effective</th>
							<th colspan="3" class="text-center">Shares</th>
							
						</tr>
					</thead>
					<tbody id="workers"></tbody>					
				</table>
				<br>
				<h4>Estimated Earnings</h4>
				<p style="font-size:11px;">Based on your average hashrate as well as the average block time and difficulty of the Ethereum network over the last 24 hours.</p>
				<table class="table">
					<thead>
						<tr> <th>Period</th> <th>ETH</th> <th>THB</th></tr>
						
					</thead>
					<tbody >
						<tr>
							<td>Day</td> 
							<td id="day-eth"><img width="18" src="default.svg"></td>
							<td id="day-thb"><img width="18" src="default.svg"></td>
						</tr>
						<tr>
							<td>Week</td> 
							<td id="week-eth"><img width="18" src="default.svg"></td>
							<td id="week-thb"><img width="18" src="default.svg"></td>
						</tr>
						<tr>
							<td>Month</td> 
							<td id="month-eth"><img width="18" src="default.svg"></td>
							<td id="month-thb"><img width="18" src="default.svg"></td>
						</tr>
					</tbody>
				</table>
				<br>	
				<h4>Last 10 Payouts</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Paid On</th>
							<th>Duration</th>
							<th>Amount</th>
							<th>Tx</th>
						</tr>
					</thead>
					<tbody id="payouts"></tbody>
				</table>

			</div>
			<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
			<script type="text/javascript">
				getData();
				setInterval(function(){
					getData()
				},30000)

				function getData(){
					$.ajax({
						url:'api.php',
						type:'get',
						data:{miner:'<?php echo $_GET['miner'] ?>'},
						dataType:'json',
						success:function(data){
							$('#walletaddress').text(data.wallet_address);
							$('#balance').text(data.balance);
							$('#reported-hashrate').text(data.hashrates.reported);
							$('#effective-hashrate').text(data.hashrates.effective);
							$('#average-hashrate').text(data.hashrates.average);
							$('#btc-price').text(data.bx_price.BTC.price);
							$('#btc-change').html(data.bx_price.BTC.change);
							$('#eth-price').text(data.bx_price.ETH.price);
							$('#eth-change').html(data.bx_price.ETH.change);

							var worker_html ="";
							$.each(data.workers, function(index, value) {
							    worker_html +="<tr><td>"+value.worker+"</td>";
								worker_html +="<td>"+value.reportedHashRate+"</td>";
								worker_html +="<td>"+value.hashrate+"</td>";
								worker_html +="<td align=center >"+value.validShares+"</td>";
								worker_html +="<td align=center><span style=color:orange>"+value.staleShares+"</span>   </td>";
								worker_html +="<td align=center><span style=color:red>"+value.invalidShares+"</span></td></tr>";
							});
							$("#workers").html(worker_html);
							$("#day-eth").html(data.earning.day.eth);
							$("#day-thb").html(data.earning.day.thb);
							$("#week-eth").html(data.earning.week.eth);
							$("#week-thb").html(data.earning.week.thb);
							$("#month-eth").html(data.earning.month.eth);
							$("#month-thb").html(data.earning.month.thb);
							$("#next-payment").html(data.next_payment_minute);

							var payout_html = "";
							$.each(data.payouts, function(index, value) {
								payout_html +="<tr><td>"+value.date+" <span class='label'>"+value.time+" </span></td>";
								payout_html +="<td> "+value.duration+" </td>";
								payout_html +="<td>"+value.amount+"</td>";
								payout_html +="<td><a target=_blank class= href='"+value.tx+"'>view</a></td></tr>";
							});
							$("#payouts").html(payout_html);
						}
					})
				}
			</script>
			<?php }else{ ?>
				<div class="col-md-12 text-center">
					<img src="favicons/apple-touch-icon.png" style="border-radius: 100px;border:solid 1px #333;margin:30px 0 0">
					<h3>Enter your wallet address</h3>
					<p>This service supported only ethermine.org pool</p>
					<form>
						<input class="form-control text-center" id="walletaddress" type="text" name="miner" placeholder="Enter your wallet address">
						<br>
						<button type="submit" class="btn btn-block">Submit</button>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
	
</body>
</html>
