<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>Pool Stats</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="framework7/css/framework7.ios.min.css">
    <link rel="stylesheet" href="framework7/css/framework7.ios.colors.min.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="framework7/css/my-app.css">
	
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
	<link rel="manifest" href="favicons/manifest.json">
	<meta name="theme-color" content="#111111">
	<style type="text/css">
		.data-table{
			
		}
		.data-table td{
			font-size:12px;
		}
		.framework7-root, body, html{
			max-width: 600px;
			margin:0 auto;
		}
		a,.layout-dark .content-block-title,.layout-dark .login-screen-content, .layout-dark .page, .layout-dark .panel, .page.layout-dark, .panel.layout-dark{
			color: #a6e22e;
		}
		.button.active{
			background: #222;
			color:#a6e22e;
			border-color: #a6e22e;
		}
		.layout-dark .card-footer, .layout-dark .card-header{
			color:#999;
		}
	</style>

</head>
<body class="layout-dark">
	
    <!-- Views-->
    <div class="views">
      <!-- Your main view, should have "view-main" class-->
      <div class="view view-main">
        <!-- Top Navbar-->
        <div class="navbar">
        	<!-- Home page navbar -->
			<div class="navbar-inner" data-page="index">			
				<div class="center">Pool Stats</div>
			</div>

			<!-- Home page navbar -->
			<div class="navbar-inner cached" data-page="ethermine">
				<div class="left"><a href="#index" class="back link"><i class="icon icon-back"></i> <span>Back</span> </a></div>
	            <div class="center">Ethermine.org</div>
	            <div class="right"></div>
			</div>

        </div>


        <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
        <div class="pages navbar-through toolbar-through theme-purple">
          	<!-- Home page -->
			<div class="page" data-page="index">
				<div class="page-content">
					<form id="from-pool" class="list-block store-data">
						<img src="favicons/apple-touch-icon.png" style="border-radius: 100px;border:solid 1px #333;margin:30px auto 0;display: block;">
					    <div class="list-block">
							<ul>
								<li>
								  <a href="#" class="item-link smart-select">
								    <select name="pool" id="pool">
								      <option value="ethermine" selected>ETH - Ethermine.org</option>
								      <option value="nanopool" disabled="">ETH - nanopool.org</option>
								    </select>
								    <div class="item-content">
								      <div class="item-inner">
								        <div class="item-title">Pool</div>
								        <div class="item-after">ETH - Ethermine.org</div>
								      </div>
								    </div>
								  </a>
								</li>
								<li>
							      	<div class="item-content">
								        <div class="item-inner">
								        	<div class="item-title label">Wallet</div>
								            <div class="item-input">
								            	<input type="text" id="wallet_address" value="<?php echo @$_GET['miner'] ?>" placeholder="Enter your wallet address">
								            </div>
								        </div>
								      </div>
							    </li>
							</ul>
						</div>
					</form>
					<div class="content-block">
					  <p><a href="#" class="button button-big active" id="btn-view-stats">View Stats</a></p>
					</div>   
				</div>
			</div>
			<!-- Ethermine page -->
			<div class="page cached" data-page="ethermine" >
				<div class="page-content" >
					
					
				    <div class="card">
					    <div class="card-header">Unpaid Balance</div>
					    <div class="card-content">
					        <div class="card-content-inner">
						        <h2 style="margin:0" id="balance"><span class="preloader"></span></h2>
							  	<span id="next-payment" style="font-size:12px;"></span><br>
							  	<span style="color:#999;font-size:12px;" id="walletaddress"></span>
					        </div>
					    </div>
					   
					</div> 

					<div class="card">
					    <div class="card-header">Hashrates</div>
					    <div class="card-content">
					        <div class="card-content-inner">
						        <div class="row">
							  		<div class="col-33" >
							  			<h4 id="reported-hashrate" style="margin:0"><span class="preloader"></span></h4>
							  			<span class="" style="color:#999">Reported</span>
						  			</div>
							  		<div class="col-33" >
							  			<h4 id="effective-hashrate" style="margin:0"><span class="preloader"></span></h4>
							  			<span class="" style="color:#999">Effective</span>
						  			</div>
							  		<div class="col-33" >
							  			<h4 id="average-hashrate" style="margin:0"><span class="preloader"></span></h4>
							  			<span class="" style="color:#999">Average</span>
							  		</div>
							  	</div>
					        </div>
					    </div>
					</div> 

					<div class="card">
					    <div class="card-header">BX Prices</div>
					    <div class="card-content">
					        <div class="card-content-inner">
						        <div class="row">
							  		<div class="col-50"><h4 style="margin:0" id="btc-price"><span class="preloader"></span></h4>
									  <span class="label" style="color:#999">BTC
									  	<span id="btc-change"> </span>
									  </span>
									  </div>
									  <div class="col-50"><h4 style="margin:0" id="eth-price"><span class="preloader"></span></h4>
									  <span class="label" style="color:#999">ETH
										  <span id="eth-change"></span>
									  </span>
									</div>
							  	</div>
					        </div>
					    </div>
					</div>
									 
					<div class="content-block-title">My Workers</div> 
					<div class="data-table card">
						<table>
							<thead>
							  <tr>
							    <th class="label-cell" with="40%">Worker</th>
							    <th class="numeric-cell">Report</th>
							    <th class="numeric-cell" >Effect</th>
							    <th class="text-center" colspan="3" >Shares</th>
							  </tr>
							</thead>
							<tbody id="workers">  
								<tr><td colspan="4"><span class="preloader"></span></td></tr>
							</tbody>
						</table>
					</div>

					<div class="content-block-title">Estimated Earnings</div> 

					<div class="data-table card">
						<table>
							<thead>
							  <tr>
							    <tr> <th>Period</th> <th>ETH</th> <th>THB</th></tr>
							  </tr>
							</thead>
							<tbody id="workers">  
								<tr>
									<td>Day</td> 
									<td id="day-eth"><span class="preloader"></span></td>
									<td id="day-thb"><span class="preloader"></span></td>
								</tr>
								<tr>
									<td>Week</td> 
									<td id="week-eth"><span class="preloader"></span></td>
									<td id="week-thb"><span class="preloader"></span></td>
								</tr>
								<tr>
									<td>Month</td> 
									<td id="month-eth"><span class="preloader"></span></td>
									<td id="month-thb"><span class="preloader"></span></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="content-block-title">Last 10 Payouts</div> 
					<div class="data-table card">
						<table>
							<thead>
							  <tr>
							    <th>Paid On</th>
								<th>Duration</th>
								<th>Amount</th>
								
							  </tr>
							</thead>
							<tbody id="payouts"></tbody>
						</table>
					</div>
				</div>
			</div>


        </div>
        
      </div>
    </div>
<!-- Path to Framework7 Library JS-->
<script type="text/javascript" src="framework7/js/framework7.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
	// Initialize App  
	var myApp = new Framework7();
	        
	// Initialize View          
	var mainView = myApp.addView('.view-main', {
	  dynamicNavbar: true,
	  domCache: true
	}) 

	var $$ = Dom7;

	var storedData = myApp.formGetData('from-pool');
	if(storedData) {
		$("#wallet_address").val(storedData.wallet_address);
		//alert(JSON.stringify(storedData));
	}
	

	$$('#btn-view-stats').on('click', function(){

		var storedData = myApp.formStoreData('from-pool', {
		    'pool':  $("#pool").val(),
		    'wallet_address': $("#wallet_address").val()
		});

		getData();
		setInterval(function(){
			getData()
		},30000)


		mainView.router.load({pageName: 'ethermine'});
	});


	function getData(){
		var pool = $("#pool").val()
		$.ajax({
			url:pool+'/api.php',
			type:'get',
			data:{miner: $("#wallet_address").val()},
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
				    worker_html +="<tr><td class='label-cell'><span style=''>"+value.worker+"</span></td>";
					worker_html +="<td class='numeric-cell'><span style=''>"+value.reportedHashRate+"</span></td>";
					worker_html +="<td class='numeric-cell'><span style=''>"+value.hashrate+"</span></td>";
					worker_html +="<td class='numeric-cell' ><span style=''>"+value.validShares+"</span></td>";
					worker_html +="<td class='numeric-cell'><span style=color:orange>"+value.staleShares+"</span>   </td>";
					worker_html +="<td class='numeric-cell'><span style=color:red>"+value.invalidShares+"</span></td></tr>";
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
					//payout_html +="<td><a target=_blank class= href='"+value.tx+"'><i class='f7-icons'>chevron_right</i></a></td></tr>";
				});
				$("#payouts").html(payout_html);
			}
		})
	}
</script>
</body>
</html>
