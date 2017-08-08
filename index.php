<?php 
if(isset($_POST['pool']) && $_POST['miner']!=""){
	$pool = $_POST['pool'];
	header('location:'.$pool.'/?miner='.$_POST['miner']);
	exit;
}
?><!DOCTYPE html>
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
		.form-control{border-radius: 0; background: #222; color:#a6e22e; border-color:#a6e22e;margin-bottom: 10px }
		.form-control:focus{box-shadow: none !important; border-color:#a6e22e !important; }
		.btn{background: #222;color:#999; }
		.btn:hover,.btn:focus,.btn:active{background: #252525;color:#999; }
	</style>
</head>
<body>
	<div class="container">

		<div class="row">
			
			<div class="col-md-12 text-center">
				
				<h1>Pool Stats</h1>
				<p>Select your pool and enter your wallet address</p>
				<form method="post" >
					<select class="form-control text-center" name="pool">
						<option value="ethermine" >ETH - ethermine.org</option>
					</select>
					<input class="form-control text-center" id="walletaddress" type="text" name="miner" placeholder="Enter your wallet address">
					<br>
					<button type="submit" class="btn btn-block">Submit</button>
				</form>
			</div>
			
		</div>
	</div>
	<script type="text/javascript">
		
	</script>
	
</body>
</html>
