<?php 
header("Cache-Control: max-age=2592000"); 
if(!isset($_COOKIE['uniqueID']))
{
	$deviceId = uniqid();
    $expire=time()+60*60*24*30*12;//however long you want
    setcookie('uniqueID', $deviceId , $expire);
}else{
	$deviceId = $_COOKIE['uniqueID'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
   
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-status-bar-style" content="#a6e22e">
    <title>ETH Pool Stats - Track your Ethereum mining pools</title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="framework7/css/framework7.ios.min.css">
    <link rel="stylesheet" href="framework7/css/framework7.ios.colors.min.css">
    <link rel="stylesheet" href="framework7/icons/css/framework7-icons.css">
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="framework7/css/my-app.css">
	
    <link rel="apple-touch-startup-image" sizes="640x960" href="favicons/splash360x460.png">
    <link rel="apple-touch-startup-image" sizes="640x960" href="favicons/splash640x960.png">

	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
	<link rel="manifest" href="favicons/manifest.json">
	<meta name="theme-color" content="#111111">
	<style type="text/css">
		body{
			background: #111;
		}
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
        .layout-dark .navbar{
            background: #9bcc3a;
            color:#000;
        }
        .layout-dark .navbar a{
            color:#000;
        }
        .button.active{
            background: #222;
            color:#a6e22e;
            border-color: #a6e22e;
        }
        .layout-dark .card-footer, .layout-dark .card-header{
            color:#999;
        }
        .tabbar a.active{
            color:#a6e22e;
        }
        .statusbar-overlay {
            background: #a6e22e;
            /* We can add transition for smooth color animation */
            -webkit-transition: 400ms;
            transition: 400ms;
           
        }
	</style>

</head>
<body class="layout-dark">
	
    <!-- Views-->
    <div  class="views tabs toolbar-fixed">
        <!-- tab1-->
        <div id="tab1" class="view tab active view-main">
            <!-- Top Navbar-->
            <div class="navbar">
                <!-- Home page navbar -->
                <div class="navbar-inner" data-page="index">            
                    <div class="center">ETH Pool Stats</div>
                </div>

                <!-- Home page navbar -->
                <div class="navbar-inner cached" data-page="pool_report">
                    <div class="left"><a href="#index" class="back link"><i class="framework7-icons">left</i> <span>Back</span> </a></div>
                    <div class="center nav-pool-name">ETH Pool Stats</div>
                    <div class="right"><a href="#" class="refresh-pool link" ><i class="framework7-icons">refresh</i> </a></div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
                <!-- Home page -->
                <div class="page" data-page="index">
                    <div class="page-content">
                        <form id="from-pool" class="list-block store-data">
                        	<input type="hidden" id="current-address" value="">
                        	<input type="hidden" id="current-pool" value="">
                            <img src="favicons/apple-touch-icon.png" style="width:20%;border-radius: 100px;border:solid 1px #333;margin:30px auto 0;display: block;">
                            <div class="list-block">
                                <ul>
                                    <li>
                                      <a href="#" class="item-link smart-select">
                                        <select name="pool" id="pool">
                                          <option value="ethermine" selected>ETH - ethermine.org</option>
                                         
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
                                                <div class="item-input ">
                                                    <input type="text" id="wallet_address" value="<?php echo $_GET['miner'] ?>" placeholder="Enter your wallet address">
                                                </div>
                                            </div>
                                          </div>
                                    </li>
                                   
                                </ul>
                            </div>
                        </form>
                        <div class="content-block" >
                          <p><a href="#" class="button button-big active" id="btn-view-stats">View Stats</a></p>
                        </div>   

                        
                        <div class="content-block-title">Track History</div>
						<div class="list-block media-list">
						  <ul id="list-track-history">
						 
						  </ul>
						</div>

                    </div>
                </div>
                <!-- Pool Report page -->
                <div class="page cached" data-page="pool_report" >
                    <div class="page-content" >
                        
                        
                        <div class="card">
                            <div class="card-header">Unpaid Balance</div>
                            <div class="card-content">
                                <div class="card-content-inner">
                                    <h2 style="margin:0" id="balance"><span class="preloader preloader-white"></span></h2>
                                    <span id="next-payment" style="font-size:12px;display: none;"></span>
                                    <span style="color:#999;font-size:12px;" id="walletaddress"></span>
                                </div>
                            </div>
                           
                        </div> 

                        <div class="card">
                            <div class="card-header">Hashrates</div>
                            <div class="card-content">
                                <div id="chartcontainer" style="height:160px;margin-top:20px;"></div>
                                <div class="card-content-inner">
                                    <div class="row">
                                        <div class="col-33" >
                                            <h4 id="reported-hashrate" style="margin:0;font-size:16px;color:#2b908f"><span class="preloader preloader-white"></span></h4>
                                            <span class="" style="color:#999">Reported</span>
                                        </div>
                                        <div class="col-33" >
                                            <h4 id="effective-hashrate" style="margin:0;font-size:16px;color:#90ee7e"><span class="preloader preloader-white"></span></h4>
                                            <span class="" style="color:#999">Current</span>
                                        </div>
                                        <div class="col-33" >
                                            <h4 id="average-hashrate" style="margin:0;font-size:16px;color:#f45b5b"><span class="preloader preloader-white"></span></h4>
                                            <span class="" style="color:#999">Average</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="card">
                            <div class="card-header">Prices</div>
                            <div class="card-content">
                                <div class="card-content-inner">
                                    <div class="row">
                                        <div class="col-50"><h4 style="margin:0" id="btc-price"><span class="preloader preloader-white"></span></h4>
                                          <span class="label" style="color:#999">BTC
                                            <span id="btc-change"> </span>
                                          </span>
                                          </div>
                                          <div class="col-50"><h4 style="margin:0" id="eth-price"><span class="preloader preloader-white"></span></h4>
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
                                    <tr><td colspan="4"><span class="preloader preloader-white"></span></td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="content-block-title">Estimated Earnings</div> 

                        <div class="data-table card">
                            <table>
                                <thead>
                                  <tr>
                                    <tr> <th>Period</th> <th>ETH</th> <th class="unit-currency">THB</th></tr>
                                  </tr>
                                </thead>
                                <tbody id="workers">  
                                    <tr>
                                        <td>Day</td> 
                                        <td id="day-eth"><span class="preloader preloader-white"></span></td>
                                        <td id="day-thb"><span class="preloader preloader-white"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Week</td> 
                                        <td id="week-eth"><span class="preloader preloader-white"></span></td>
                                        <td id="week-thb"><span class="preloader preloader-white"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Month</td> 
                                        <td id="month-eth"><span class="preloader preloader-white"></span></td>
                                        <td id="month-thb"><span class="preloader preloader-white"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="content-block-title">Payouts</div> 
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

        <!-- tab2-->
        <div id="tab2" class="view tab view-marketcap">
            <!-- Top Navbar-->
            <div class="navbar">
                <!-- Market page navbar -->
                <div class="navbar-inner" data-page="marketcap">            
                    <div class="center">Market Cap</div>
                    <div class="right"><a href="#select-marketcap" class="more-marketcap link" ><i class="framework7-icons">more_vertical_round</i> </a></div>
                </div>
                <!-- Select coin page navbar -->
                <div class="navbar-inner cached" data-page="select-marketcap">
                    <div class="left"><a href="#marketcap" class="back link"><i class="framework7-icons">left</i> <span>Back</span> </a></div>
                    <div class="center">Select Coin</div>
                    <div class="right"></div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
                <!-- Market Cap page -->
                <div class="page" data-page="marketcap">
                    <!-- Search Bar overlay -->
                    <div class="searchbar-overlay"></div>

                    <div class="page-content pull-to-refresh-content pull-marketcap">
                        <!-- Default pull to refresh layer-->
                        <div class="pull-to-refresh-layer">
                          <div class="pull-to-refresh-arrow"></div>
                        </div>
                        <div class="list-block list-block-search media-list" id="marketcap-list" style="margin:0">
                         
                        </div>
                    </div>

                </div>
                <!-- Market Cap page -->
                <div class="page cached" data-page="select-marketcap">
                    <!-- Search Bar -->
                    <form data-search-list=".list-block-search" data-search-in=".item-title" class="searchbar searchbar-init">
                        <div class="searchbar-input">
                          <input type="search" placeholder="Search"><a href="#" class="searchbar-clear"></a>
                        </div><a href="#" class="searchbar-cancel">Cancel</a>
                    </form>

                    <!-- Search Bar overlay -->
                    <div class="searchbar-overlay"></div>

                    <div class="page-content">
                        
                        <!-- This block will be displayed if nothing found -->
                        <div class="content-block searchbar-not-found">
                          <div class="content-block-inner">Nothing found</div>
                        </div>
                        
                        <div class="list-block list-block-search media-list" id="select-marketcap-list" style="margin:0">							       
                        </div>
                    </div>

                </div>
                
            </div>
        </div>

        <!-- tab3-->
        <div id="tab3" class="view tab view-news">
            <!-- Top Navbar-->
            <div class="navbar">
                <!-- Home page navbar -->
                <div class="navbar-inner" data-page="index">            
                    <div class="center">News</div>
                    <div class="right"><a href="#" class="refresh-news link" ><i class="framework7-icons">refresh</i> </a></div>
                </div>
                <!-- Select read news navbar -->
                <div class="navbar-inner cached" data-page="readnews">
                    <div class="left"><a href="#news" class="back link"><i class="framework7-icons">left</i> <span>Back</span> </a></div>
                    <div class="center">News</div>
                    <div class="right"></div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
                <!-- News page -->
                <div class="page" data-page="news">
                    <div class="page-content pull-to-refresh-content pull-news">
                        <!-- Default pull to refresh layer-->
                        <div class="pull-to-refresh-layer">
                          <div class="pull-to-refresh-arrow"></div>
                        </div>

                        <div class="list-block media-list" id="news-list" style="margin:0">
                          
                        </div>
                    </div>
                </div>

                <!-- Read news -->
                <div class="page cached" data-page="readnews">
                    <div class="page-content ">
                        <div id="news-content">
                          	<span class="preloader preloader-white"></span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- tab4-->
        <div id="tab4" class="view tab view-setting">
            <!-- Top Navbar-->
            <div class="navbar">
                <!-- Home page navbar -->
                <div class="navbar-inner" data-page="index">            
                    <div class="center">More</div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
                <!-- Market Cap page -->
                <div class="page" data-page="setting">
                    <div class="page-content">

                        <div class="content-block-title">Setting</div>
                         <form id="form-setting" class="list-block store-data">
                            <ul>
                                <li>
                                  <a href="#" class="item-link smart-select">
                                    <select name="currency" id="currency">
                                        <option value="USD">USD - United States Dollars</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="GBP">GBP - United Kingdom Pounds</option>
                                        <option value="DZD">DZD - Algeria Dinars</option>
                                        <option value="ARP">ARP - Argentina Pesos</option>
                                        <option value="AUD">AUD - Australia Dollars</option>
                                        <option value="ATS">ATS - Austria Schillings</option>
                                        <option value="BSD">BSD - Bahamas Dollars</option>
                                        <option value="BBD">BBD - Barbados Dollars</option>
                                        <option value="BEF">BEF - Belgium Francs</option>
                                        <option value="BMD">BMD - Bermuda Dollars</option>
                                        <option value="BRR">BRR - Brazil Real</option>
                                        <option value="BGL">BGL - Bulgaria Lev</option>
                                        <option value="CAD">CAD - Canada Dollars</option>
                                        <option value="CLP">CLP - Chile Pesos</option>
                                        <option value="CNY">CNY - China Yuan Renmimbi</option>
                                        <option value="CYP">CYP - Cyprus Pounds</option>
                                        <option value="CSK">CSK - Czech Republic Koruna</option>
                                        <option value="DKK">DKK - Denmark Kroner</option>
                                        <option value="NLG">NLG - Dutch Guilders</option>
                                        <option value="XCD">XCD - Eastern Caribbean Dollars</option>
                                        <option value="EGP">EGP - Egypt Pounds</option>
                                        <option value="FJD">FJD - Fiji Dollars</option>
                                        <option value="FIM">FIM - Finland Markka</option>
                                        <option value="FRF">FRF - France Francs</option>
                                        <option value="DEM">DEM - Germany Deutsche Marks</option>
                                        <option value="XAU">XAU - Gold Ounces</option>
                                        <option value="GRD">GRD - Greece Drachmas</option>
                                        <option value="HKD">HKD - Hong Kong Dollars</option>
                                        <option value="HUF">HUF - Hungary Forint</option>
                                        <option value="ISK">ISK - Iceland Krona</option>
                                        <option value="INR">INR - India Rupees</option>
                                        <option value="IDR">IDR - Indonesia Rupiah</option>
                                        <option value="IEP">IEP - Ireland Punt</option>
                                        <option value="ILS">ILS - Israel New Shekels</option>
                                        <option value="ITL">ITL - Italy Lira</option>
                                        <option value="JMD">JMD - Jamaica Dollars</option>
                                        <option value="JPY">JPY - Japan Yen</option>
                                        <option value="JOD">JOD - Jordan Dinar</option>
                                        <option value="KRW">KRW - Korea (South) Won</option>
                                        <option value="LBP">LBP - Lebanon Pounds</option>
                                        <option value="LUF">LUF - Luxembourg Francs</option>
                                        <option value="MYR">MYR - Malaysia Ringgit</option>
                                        <option value="MXP">MXP - Mexico Pesos</option>
                                        <option value="NLG">NLG - Netherlands Guilders</option>
                                        <option value="NZD">NZD - New Zealand Dollars</option>
                                        <option value="NOK">NOK - Norway Kroner</option>
                                        <option value="PKR">PKR - Pakistan Rupees</option>
                                        <option value="XPD">XPD - Palladium Ounces</option>
                                        <option value="PHP">PHP - Philippines Pesos</option>
                                        <option value="XPT">XPT - Platinum Ounces</option>
                                        <option value="PLZ">PLZ - Poland Zloty</option>
                                        <option value="PTE">PTE - Portugal Escudo</option>
                                        <option value="ROL">ROL - Romania Leu</option>
                                        <option value="RUR">RUR - Russia Rubles</option>
                                        <option value="SAR">SAR - Saudi Arabia Riyal</option>
                                        <option value="XAG">XAG - Silver Ounces</option>
                                        <option value="SGD">SGD - Singapore Dollars</option>
                                        <option value="SKK">SKK - Slovakia Koruna</option>
                                        <option value="ZAR">ZAR - South Africa Rand</option>
                                        <option value="KRW">KRW - South Korea Won</option>
                                        <option value="ESP">ESP - Spain Pesetas</option>
                                        <option value="XDR">XDR - Special Drawing Right (IMF)</option>
                                        <option value="SDD">SDD - Sudan Dinar</option>
                                        <option value="SEK">SEK - Sweden Krona</option>
                                        <option value="CHF">CHF - Switzerland Francs</option>
                                        <option value="TWD">TWD - Taiwan Dollars</option>
                                        <option value="THB" selected="selected">THB - Thailand Baht</option>
                                        <option value="TTD">TTD - Trinidad and Tobago Dollars</option>
                                        <option value="TRL">TRL - Turkey Lira</option>
                                        <option value="VEB">VEB - Venezuela Bolivar</option>
                                        <option value="ZMK">ZMK - Zambia Kwacha</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="XCD">XCD - Eastern Caribbean Dollars</option>
                                        <option value="XDR">XDR - Special Drawing Right (IMF)</option>
                                        <option value="XAG">XAG - Silver Ounces</option>
                                        <option value="XAU">XAU - Gold Ounces</option>
                                        <option value="XPD">XPD - Palladium Ounces</option>
                                        <option value="XPT">XPT - Platinum Ounces</option>
                                    </select>
                                    <div class="item-content">
                                      <div class="item-inner">
                                        <div class="item-title">Currency</div>
                                        <div class="item-after">THB - Thailand Baht</div>
                                      </div>
                                    </div>
                                  </a>
                                </li>                                
                            </ul>
                        </form>

                        <div class="content-block-title">Stats</div>
                        <div class="list-block">
                            <ul>
                                <li class="item-content">
                                  <div class="item-inner">
                                    <div class="item-title">Online</div>
                                    <div class="item-after online-count"><span class="preloader preloader-white"></span></div>
                                  </div>
                                </li>
                                <li class="item-content">
                                 
                                  <div class="item-inner">
                                    <div class="item-title">DeviceID</div>
                                    <div class="item-after deviceId" style="font-size:10px;"></div>
                                  </div>
                                </li>
                                
                            </ul>
                        </div>

                        

                        <div class="content-block-title">Donate</div>
                        <div class="list-block">
                            <ul>
                                <li class="item-content">
                                  <div class="item-inner">
                                    <div class="item-title">BTC</div>
                                    <div class="item-after" style="font-size:11px;">1PcAw1WT7nj8VWRaERtjEXXy954tfhZpF9</div>
                                  </div>
                                </li>
                                <li class="item-content">
                                 
                                  <div class="item-inner">
                                    <div class="item-title">ETH</div>
                                    <div class="item-after" style="font-size:11px;">0x270e6aa94B84Abd514B293d8F67101DA18b1609c</div>
                                  </div>
                                </li>
                                
                            </ul>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Tab bar with tab links -->
        <div class="toolbar tabbar">
            <div class="toolbar-inner">
                <a href="#tab1" class="tab-link active">
                    <i class="f7-icons">cloud</i>
                </a>
                <a href="#tab2" class="tab-link">
                    <i class="f7-icons">money_dollar</i>
                </a>
                <a href="#tab3" class="tab-link">
                    <i class="f7-icons">list</i>
                </a>
                <a href="#tab4" class="tab-link">
                    <i class="f7-icons">more_round</i>
                </a>
            </div>
        </div> 

    </div>
<!-- Path to Framework7 Library JS-->
<script type="text/javascript" src="framework7/js/framework7.min.js"></script>
<script type="text/javascript" src="framework7/js/gathering.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="js/hightheme.js"></script>
<script type="text/javascript">

// Initialize Firebase
var config = {
    apiKey: "AIzaSyBC85sGN_qp6XjBY3FXtk_NWsGEsm-hSNM",
    authDomain: "pool-stats-a06b7.firebaseapp.com",
    databaseURL: "https://pool-stats-a06b7.firebaseio.com",
    projectId: "pool-stats-a06b7",
    storageBucket: "pool-stats-a06b7.appspot.com",
    messagingSenderId: "746391640103"
};
firebase.initializeApp(config);

	Number.prototype.formatMoney = function(c, d, t){
	var n = this, 
	    c = isNaN(c = Math.abs(c)) ? 2 : c, 
	    d = d == undefined ? "." : d, 
	    t = t == undefined ? "," : t, 
	    s = n < 0 ? "-" : "", 
	    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
	    j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 };

	var deviceId = '<?php echo $deviceId; ?>';
	$('.deviceId').text(deviceId);

	var pools = {'ethermine':'ETH - ethermine.org','nanopool-eth' : 'ETH - nanopool.org','nanopool-etc' : 'ETC - nanopool.org'};

    // Initialize App  
    var myApp = new Framework7();
            
    // Initialize View          
    var mainView = myApp.addView('.view-main', {
      dynamicNavbar: true,
      domCache: true
    }) 

    var marketcapView = myApp.addView('.view-marketcap', {
      dynamicNavbar: true,
      domCache: true
    }) 

    var newsView = myApp.addView('.view-news', {
      dynamicNavbar: true,
      domCache: true
    })

    var settingView = myApp.addView('.view-setting', {
      dynamicNavbar: true,
      domCache: true
    }) 

    var $$ = Dom7;

    var storedData = myApp.formGetData('from-pool');
    if(storedData) {
        $("#wallet_address").val(storedData.wallet_address);    
    }

    $('#currency').change(function(){
        
        var storedData = myApp.formStoreData('form-setting', {
            'currency':  $(this).val()
        }); 
        $('.unit-currency').text($(this).val());
    });

    $('.unit-currency').text($("#currency").val());



    $('.tab-link').on('click', function(){
        if($(this).attr('href')=="#tab2"){
             getMarketCap(0);
        }
        if($(this).attr('href')=="#tab3"){
            getNews(0);
         
        }
    });

    $('.refresh-pool').on('click', function(){ 
        if($("#current-pool").val()=="ethermine"){
            getDataEthermine(1,$("#current-pool").val(),$("#current-address").val())
        }else{
            getData(1,$("#current-pool").val(),$("#current-address").val()); 
        }
    });
    $('.refresh-marketcap').on('click', function(){ getMarketCap(); });
    $('.refresh-news').on('click', function(){ getNews(); });

    $$('.pull-to-refresh-content.pull-marketcap').on('ptr:refresh', function (e) { getMarketCap();  myApp.pullToRefreshDone();});
    $$('.pull-to-refresh-content.pull-news').on('ptr:refresh', function (e) { getNews();  myApp.pullToRefreshDone();});
   
    $$('#btn-view-stats').on('click', function(){
    	var pool = $("#pool").val();
    	var address = $("#wallet_address").val();

    	if(address==""){
    		alert("Please enter your wallet address");
    		return false;
    	}
    	//var auto_view = $("#auto_view:checked").length==1 ? 'yes' : 'no';
        var storedData = myApp.formStoreData('from-pool', {
            'pool':  pool,
            'wallet_address': address
        });	

        $(".nav-pool-name").text($("#pool option:selected").text())

        setViewStatsHistory(deviceId, pool, address);

        if(pool=="ethermine"){
            getDataEthermine(1,pool,address);
        }else{
            getData(1,pool,address);
        }

        mainView.router.load({pageName: 'pool_report'});
    });
    setTimeout(function(){
    	if($("#wallet_address").val()!=""){
			$$("#btn-view-stats").click();
    	}
	},1500)

    

 	$$('.more-marketcap').on('click', function(){
        marketcapView.router.load({pageName: 'select-marketcap'});
    });


   
    function getDataEthermine(show_preload=0,pool,address){

        if(show_preload==1){
        var preLoader = '<span class="preloader preloader-white"></span>';

            $('#balance').html(preLoader);
            $('#reported-hashrate').html(preLoader);
            $('#effective-hashrate').html(preLoader);
            $('#average-hashrate').html(preLoader);
            $('#btc-price').html(preLoader);   
            $('#eth-price').html(preLoader);     
            $("#workers").html(preLoader);
            $("#day-eth").html(preLoader);
            $("#day-thb").html(preLoader);
            $("#week-eth").html(preLoader);
            $("#week-thb").html(preLoader);
            $("#month-eth").html(preLoader);
            $("#month-thb").html(preLoader);
            $("#payouts").html(preLoader);
        }
        var currency = $("#currency").val();
        getEthermineCurrentStats(address);
         $("#current-address").val(address);
        $("#current-pool").val(pool);
        
    }

    function getEthermineCurrentStats(address){
        var currency = $("#currency").val();

        $.ajax({
            url:'https://api.ethermine.org/miner/'+address+'/currentStats',
            type:'get',
            cache:true,
            dataType:'json',
            success:function(data){
                var data = data.data;
                var balance = parseFloat(data.unpaid/1000000000000000000).formatMoney(5, '.', ',') + ' ETH'
                var reportedHashRate = parseFloat(data.reportedHashrate/1000000).formatMoney(1, '.', ',')+ ' Mh/s' ;
                var currentHashrate = parseFloat(data.currentHashrate/1000000).formatMoney(1, '.', ',')+ ' Mh/s' ;
                var averageHashrate = parseFloat(data.averageHashrate/1000000).formatMoney(1, '.', ',')+ ' Mh/s' ;
                var coinsPerMin = data.coinsPerMin ;
                $('#walletaddress').text(address);
                $('#balance').text(balance);
                $('#reported-hashrate').text(reportedHashRate);
                $('#effective-hashrate').text(currentHashrate);
                $('#average-hashrate').text(averageHashrate);

                //get chart
                $.ajax({
                    url:'https://api.ethermine.org/miner/'+address+'/history',
                    type:'get',
                    dataType:'json',
                    success:function(history){

                        var series = [];
                        var serie1 = []
                        var serie2 = []
                        var serie3 = []
                        var serie4 = []
                        $.each(history.data, function(index, value) {
                            serie1[index]  = value.reportedHashrate;
                            serie2[index]  = value.currentHashrate;
                            serie3[index]  = value.averageHashrate;
                            serie4[index]  = value.validShares;
                        });
                        series = [{
                                name: 'Reported',
                                data: serie1
                            }, {
                                name: 'Current',
                                data: serie2
                            }, {
                                name: 'Average',
                                data: serie3
                            }];
                      
                        Highcharts.chart('chartcontainer', {
                            title: {
                                text: ''
                            },
                            yAxis: {
                                title: {
                                    text: null
                                }
                            },
                            xAxis: {
                               
                                title: {
                                    text: null
                                },
                                labels: {
                                 enabled:false 
                                }

                            },
                            legend:{
                                enabled:false
                            },
                            series: series

                        });
                        
                    }
                });


                //get workers
                $.ajax({
                    url:'https://api.ethermine.org/miner/'+address+'/workers',
                    type:'get',
                    dataType:'json',
                    success:function(workers){
                        var worker_html ="";
                        $.each(workers.data, function(index, value) {
                            worker_html +="<tr><td class='label-cell'><span style=''>"+value.worker+"</span></td>";
                            worker_html +="<td class='numeric-cell'><span style=''>"+parseFloat(value.reportedHashrate/1000000).formatMoney(1, '.', ',')+"</span></td>";
                            worker_html +="<td class='numeric-cell'><span style=''>"+parseFloat(value.currentHashrate/1000000).formatMoney(1, '.', ',')+"</span></td>";
                            worker_html +="<td class='numeric-cell' ><span style=''>"+value.validShares+"</span></td>";
                            worker_html +="<td class='numeric-cell'><span style=color:orange>"+value.staleShares+"</span>   </td>";
                            worker_html +="<td class='numeric-cell'><span style=color:red>"+value.invalidShares+"</span></td></tr>";
                        });
                        $("#workers").html(worker_html);
                        
                    }
                });

                //get payouts
                $.ajax({
                    url:'https://api.ethermine.org/miner/'+address+'/payouts',
                    type:'get',
                    dataType:'json',
                    success:function(payouts){
                        var payout_html = "";

                        $.each(payouts.data, function(index, value) {
                            var d = new Date(value.paidOn*1000);
                            var duration = d.getHours();
                            var date = d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                            duration = "-";
                            if(typeof payouts.data[index+1] != "undefined"){
                                duration = value.paidOn - payouts.data[index+1].paidOn;
                                duration = (duration/60/60).formatMoney(0, '.', ',')+' Hr';
                            }
                            payout_html +="<tr><td>"+date+"</td>";
                            payout_html +="<td> "+duration+" </td>";
                            payout_html +="<td>"+(value.amount/1000000000000000000).formatMoney(5, '.', ',')+" ETH</td>";
                           
                        });
                        $("#payouts").html(payout_html);
                        
                    }
                });


                //get prices
                $.ajax({
                    url:'price.php',
                    type:'get',
                    data:{currency:currency},
                    dataType:'json',
                    success:function(data){
                        $('#btc-price').text(data.btc_price.formatMoney(0, '.', ',')+" "+currency);
                        $('#btc-change').html(data.btc_price_change);
                        $('#eth-price').text(data.eth_price.formatMoney(0, '.', ',') +" "+currency);
                        $('#eth-change').html(data.eth_price_change);

                        var earning_day_eth =  (coinsPerMin*1440) ;
                        var earning_day_thb =  (coinsPerMin*1440) * data.eth_price;
                        var earning_week_eth =  coinsPerMin*1440*7 ;
                        var earning_week_thb =  (coinsPerMin*1440*7) * data.eth_price;
                        var earning_month_eth =  coinsPerMin*1440*30 ;
                        var earning_month_thb =  (coinsPerMin*1440*30) * data.eth_price;

                        $("#day-eth").html(earning_day_eth.formatMoney(5, '.', ','));
                        $("#day-thb").html(earning_day_thb.formatMoney(0, '.', ','));
                        $("#week-eth").html(earning_week_eth.formatMoney(5, '.', ','));
                        $("#week-thb").html(earning_week_thb.formatMoney(0, '.', ','));
                        $("#month-eth").html(earning_month_eth.formatMoney(5, '.', ','));
                        $("#month-thb").html(earning_month_thb.formatMoney(0, '.', ','));
                    }
                });
               
            }
        });
    }

    function getData(show_preload=0,pool,address){

        if(show_preload==1){
        var preLoader = '<span class="preloader preloader-white"></span>';

            $('#balance').html(preLoader);
            $('#reported-hashrate').html(preLoader);
            $('#effective-hashrate').html(preLoader);
            $('#average-hashrate').html(preLoader);
            $('#btc-price').html(preLoader);   
            $('#eth-price').html(preLoader);     
	        $("#workers").html(preLoader);
	        $("#day-eth").html(preLoader);
	        $("#day-thb").html(preLoader);
	        $("#week-eth").html(preLoader);
	        $("#week-thb").html(preLoader);
	        $("#month-eth").html(preLoader);
	        $("#month-thb").html(preLoader);
	        $("#payouts").html(preLoader);
        }
        var currency = $("#currency").val();

        $.ajax({
            url:pool+'/api.php',
            type:'get',
            data:{miner: address,currency:currency},
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
                $("#current-address").val(address);
                $("#current-pool").val(pool);

                var payout_html = "";
                $.each(data.payouts, function(index, value) {
                    payout_html +="<tr><td>"+value.date+" <span class='label'>"+value.time+" </span></td>";
                    payout_html +="<td> "+value.duration+" </td>";
                    payout_html +="<td>"+value.amount+"</td>";
                    //payout_html +="<td><a target=_blank class= href='"+value.tx+"'><i class='f7-icons'>chevron_right</i></a></td></tr>";
                });
                $("#payouts").html(payout_html);
            }
        });
    }

    realtimeMarketcap();
    function realtimeMarketcap(){
        var currency = $("#currency").val();
    	firebase.database().ref('/marketcap/'+currency+'/data').on('value', function(snapshot) {
	    	renderMarketCapList(snapshot.val());
		
			myApp.initImagesLazyLoad('.view-marketcap .page-content');

	        var mySearchbar = $$('.searchbar')[0].f7Searchbar;

	        $('.label-checkbox').on('click', function(){
	        	setTimeout(function(){
	        		var selected_coin = []
			    	$('.select-coin-checkbox:checked').each(function(index, el) {
			    		selected_coin[index] = $(this).val();
			    	});
			    	myApp.formStoreData('selected_coin', selected_coin);
			    	var selected_coin = myApp.formGetData('selected_coin');
	            	renderMarketCapList(snapshot.val(),1,0);
	        	},200)
		    });
	    });
    }

    function getMarketCap(preload=1){
    	var currency = $("#currency").val();
    	if(preload==1){
        	$("#marketcap-list").html('<div style="text-align:center;margin:30px;"><span class="preloader preloader-white"></span></div>');
    	}
        setTimeout(function(){
        	realtimeMarketcap()
        },500)
        $.ajax({
            url:'https://api.coinmarketcap.com/v1/ticker/?limit=300&convert='+currency,
            type:'get',
            dataType:'json',
            cache:false,
            success:function(data){
            	var ref = firebase.database().ref('marketcap/'+currency);
				ref.update({
					data : data
				});   
            }
        });
    }

    function renderMarketCapList(data,marketList=1,selectCoin=1){
    	var default_coin = ['bitcoin','ethereum','ripple','litecoin','dash','ethereum-classic','monero','omisego'];
    	var html="<ul>";
        var html_select="<ul>";
    	var selected_coin = myApp.formGetData('selected_coin');
        var currency = $("#currency").val();
        var currency_field = currency.toLowerCase();
        //console.log(selected_coin)
        if(typeof selected_coin == "undefined" || selected_coin == null){
        	selected_coin = default_coin;
        }
    	$.each(data, function(index, value) {

        	if(selected_coin.indexOf(value.id)!=-1){
                var change = value.percent_change_24h>0 ? "<span style='color:#44d844'>(+"+value.percent_change_24h+"%)</span>" : "<span style='color:#ec2828'>("+value.percent_change_24h+"%)</span>";
                html +="<li>";
                html +="  <div class='item-content'>";
                html +="    <div class='item-media'><img src='https://files.coinmarketcap.com/static/img/coins/32x32/"+value.id+".png' width='25' height='25'></div>";
                html +="    <div class='item-inner'>";
                html +="      <div class='item-subtitle' style='color:#ddd;font-size:13px;float:right;text-align:right;'>"+parseFloat(value['price_'+currency_field]).formatMoney(2, '.', ',')+" "+currency+"<br>"+change+"</div>";
                html +="      <div class='item-title-row'>";
                html +="        <div class='item-title' style='font-size:13px;'>"+value.name+" ("+value.symbol+")</div>";
                html +="      </div>";
                html +="      <div class='item-subtitle' style='color:#999;font-size:12px;'>"+nFormatter(parseFloat(value['market_cap_'+currency_field]),1)+" "+currency+"</div>";
                html +="    </div>";
                html +="  </div>";
                html +="</li>";
            }

            var checked = selected_coin.indexOf(value.id)!=-1 ? "checked='checked'" : "";
            html_select +="<li>";
		    html_select +="  <label class='label-checkbox item-content'>";
		    html_select +="    <input type='checkbox' class='select-coin-checkbox' name='selected-coin' value='"+value.id+"' "+checked+">";
		    html_select +="    <div class='item-media'>";
		    html_select +="      <i class='icon icon-form-checkbox'></i>";
		    html_select +="    </div>";
		    html_select +="    <div class='item-inner'>";
		    html_select +="      <div class='item-title'>"+value.name+" ("+value.symbol+")</div>";
		    html_select +="    </div>";
		    html_select +="  </label>";
		    html_select +="</li>";
        });
            html +="</ul>";
            html_select +="</ul>";
        if(marketList==1){
        	$("#marketcap-list").html(html);
        }
        if(selectCoin==1){
        	$("#select-marketcap-list").html(html_select);
        }
    }

    getRealtimeNews()
    function getRealtimeNews(){
	    firebase.database().ref('/news/data').on('value', function(snapshot) {
	    	var html="<ul>";
	    	snapshot.forEach((duckSnap) => {
	  			const duck = duckSnap.val();
	                html +="<li>";
	                html +="  <a data-link='"+duck.link+"' href='#' class='item-link news-item item-content'>";
	                html +="    <div class='item-inner'>";
	                html +="      <div class='item-title-row'>";
	                html +="        <div class='item-title' style='font-size:12px;'>Siam Blockchain</div>";
	                html +="        <div class='item-after'></div>";
	                html +="      </div>";
	                html +="      <div class='item-subtitle' style='color:#999;font-size:11px;'>"+duck.pubDate+"</div>";
	                html +="      <div class='item-text' style='color:#ccc'>"+duck.title+"</div>";
	                html +="    </div>";
	                html +="  </a>";
	                html +="</li>";
	        });
	        html +="</ul>";
	        $("#news-list").html(html); 

	        $$('.news-item').on('click', function(){
		    	var link = $$(this).attr('data-link');
		    	window.open(link)
		        //newsView.router.load({pageName: 'readnews'});
		    }); 
		});
	}

    function getNews(preload=1){
    	if(preload==1){
        	$("#news-list").html('<div style="text-align:center;margin:30px;"><span class="preloader preloader-white"></span></div>');
    	}
       	setTimeout(function(){
       		 getRealtimeNews();
       		},500)
        $.ajax({
            url:'news.php',
            type:'get',
            dataType:'json',
            cache:false,
            success:function(data){
            	var ref = firebase.database().ref('news');
				ref.update({
					data : data.channel.item
				});
            }
        });
    }
    function nFormatter(num, digits) {
	  var si = [
	    { value: 1E6,  symbol: "M" },
	    { value: 1E3,  symbol: "k" }
	  ], rx = /\.0+$|(\.[0-9]*[1-9])0+$/, i;
	  for (i = 0; i < si.length; i++) {
	    if (num >= si[i].value) {
	      return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
	    }
	  }
	  return num.toFixed(digits).replace(rx, "$1");
	}
  

  var gathering = new Gathering(firebase.database(), 'users-online'); 
	gathering.join(); 
	gathering.onUpdated(function(count, users) {
		$('.online-count').text(count) 
	});

	function setViewStatsHistory (deviceId, pool, address) {
        var key = pool+'|'+address
  		var ref = firebase.database().ref('users/' + deviceId + '/pools/'+key);
		ref.update({
			address : address,
            pool : pool,
			time : Math.floor(Date.now() / 1000),
		});
		
	}
	getStatsHistroy (deviceId,pools)
	function getStatsHistroy (deviceId,pools) {
        firebase.database().ref('/users/' + deviceId + '/pools').orderByChild("time").on('value', function(snapshot) {
		  	//console.log(snapshot.val());
		  	html = "";
		  	snapshot.forEach((duckSnap) => {
		  		const duck = duckSnap.val()
			  	html +="<li>";
			    html +="  <a href='#' class='item-link item-content track-history-item' data-pool='"+duck.pool+"' data-address='"+duck.address+"' data-poolname='"+pools[duck.pool]+"'>";
			    html +="    <div class='item-inner'>";
			    html +="      <div class='item-title-row'>";
			    html +="        <div class='item-title' style='font-size:13px;'>"+pools[duck.pool]+"</div>";
			    html +="      </div>";
			    html +="      <div class='item-subtitle' style='color:#999;font-size:11px;'>"+duck.address+"</div>";
			    html +="    </div>";
			    html +="  </a>";
			    html +="</li>";
		    });

		    $("#list-track-history").html(html);

		    $$('.track-history-item').on('click', function(){
		    	var pool = $$(this).attr('data-pool');
		    	var address = $$(this).attr('data-address');
		        $(".nav-pool-name").text($$(this).attr('data-poolname'))

		        getData(1,pool,address);

		        mainView.router.load({pageName: 'pool_report'});
		    });

		});
		
	}
	function resizeIframe(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	  }
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105294635-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
