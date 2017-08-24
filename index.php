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
    <link rel="stylesheet" href="framework7/icons/css/framework7-icons.css">
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
                    <div class="center">Pool Stats</div>
                </div>

                <!-- Home page navbar -->
                <div class="navbar-inner cached" data-page="ethermine">
                    <div class="left"><a href="#index" class="back link"><i class="framework7-icons">left</i> <span>Back</span> </a></div>
                    <div class="center">Ethermine.org</div>
                    <div class="right"></div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
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
                                                    <input type="text" id="wallet_address" value="" placeholder="Enter your wallet address">
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
                                    <h2 style="margin:0" id="balance"><span class="preloader preloader-white"></span></h2>
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
                                            <h4 id="reported-hashrate" style="margin:0"><span class="preloader preloader-white"></span></h4>
                                            <span class="" style="color:#999">Reported</span>
                                        </div>
                                        <div class="col-33" >
                                            <h4 id="effective-hashrate" style="margin:0"><span class="preloader preloader-white"></span></h4>
                                            <span class="" style="color:#999">Effective</span>
                                        </div>
                                        <div class="col-33" >
                                            <h4 id="average-hashrate" style="margin:0"><span class="preloader preloader-white"></span></h4>
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
                                    <tr> <th>Period</th> <th>ETH</th> <th>THB</th></tr>
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

        <!-- tab2-->
        <div id="tab2" class="view tab view-marketcap">
            <!-- Top Navbar-->
            <div class="navbar">
                <!-- Home page navbar -->
                <div class="navbar-inner" data-page="index">            
                    <div class="center">Market Cap</div>
                    <div class="right"><a href="#" class="refresh-marketcap link" ><i class="framework7-icons">refresh</i> </a></div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
                <!-- Market Cap page -->
                <div class="page" data-page="marketcap">
                    <!-- Search Bar -->
                    <form data-search-list=".list-block-search" data-search-in=".item-title" class="searchbar searchbar-init">
                        <div class="searchbar-input">
                          <input type="search" placeholder="Search"><a href="#" class="searchbar-clear"></a>
                        </div><a href="#" class="searchbar-cancel">Cancel</a>
                    </form>

                    <!-- Search Bar overlay -->
                    <div class="searchbar-overlay"></div>

                    <div class="page-content pull-to-refresh-content pull-marketcap">
                        <!-- Default pull to refresh layer-->
                        <div class="pull-to-refresh-layer">
                          <div class="pull-to-refresh-arrow"></div>
                        </div>
                        <!-- This block will be displayed if nothing found -->
                        <div class="content-block searchbar-not-found">
                          <div class="content-block-inner">Nothing found</div>
                        </div>
                        
                        <div class="list-block list-block-search media-list" id="marketcap-list" style="margin:0">
                         
                        </div>
                    </div>

                </div>
                
            </div>
        </div>

        <!-- tab3-->
        <div id="tab3" class="view tab view-favorite">
            <!-- Top Navbar-->
            <div class="navbar">
                <!-- Home page navbar -->
                <div class="navbar-inner" data-page="index">            
                    <div class="center">News</div>
                    <div class="right"><a href="#" class="refresh-news link" ><i class="framework7-icons">refresh</i> </a></div>
                </div>
            </div>
            <!-- Pages, because we need fixed-through navbar and toolbar, it has additional appropriate classes-->
            <div class="pages navbar-through toolbar-through">
                <!-- Market Cap page -->
                <div class="page" data-page="favorite">
                    <div class="page-content pull-to-refresh-content pull-news">
                        <!-- Default pull to refresh layer-->
                        <div class="pull-to-refresh-layer">
                          <div class="pull-to-refresh-arrow"></div>
                        </div>

                        <div class="list-block media-list" id="news-list" style="margin:0">
                          
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
                    <i class="f7-icons">graph_round</i>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
    // Initialize App  
    var myApp = new Framework7();
            
    // Initialize View          
    var mainView = myApp.addView('.view-main,.view-marketcap', {
      dynamicNavbar: true,
      domCache: true
    }) 

    

    var $$ = Dom7;


    

    var storedData = myApp.formGetData('from-pool');
    if(storedData) {
        $("#wallet_address").val(storedData.wallet_address);
        //alert(JSON.stringify(storedData));
    }

    
    

    $('.tab-link').on('click', function(){
        if($(this).attr('href')=="#tab2"){
            if($('#marketcap-list .item-content').length==0){
                getMarketCap();
            }
        }
        if($(this).attr('href')=="#tab3"){
            if($('#news-list .item-content').length==0){
                getNews();
            }
        }
    });

    $('.refresh-marketcap').on('click', function(){ getMarketCap(); });
    $('.refresh-news').on('click', function(){ getNews(); });

    $$('.pull-to-refresh-content.pull-marketcap').on('ptr:refresh', function (e) { getMarketCap();  myApp.pullToRefreshDone();});
    $$('.pull-to-refresh-content.pull-news').on('ptr:refresh', function (e) { getNews();  myApp.pullToRefreshDone();});
    

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
            url:'https://pool-stats.herokuapp.com/'+pool+'/api.php',
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
        });
    }

    function getMarketCap(){
        $("#marketcap-list").html('<div style="text-align:center;margin:30px;"><span class="preloader preloader-white"></span></div>');
        $.ajax({
            url:'https://pool-stats.herokuapp.com/marketcap.php',
            type:'get',
            dataType:'json',
            cache:true,
            success:function(data){
                var html="<ul>";
                $.each(data, function(index, value) {
                    var change = value.percent_change_24h>0 ? "<span style='color:#44d844'>+"+value.percent_change_24h+"%</span>" : "<span style='color:#ec2828'>"+value.percent_change_24h+"%</span>";
                    html +="<li>";
                    html +="  <div class='item-content'>";
                    html +="    <div class='item-media'><img class='lazy lazy-fadein' data-src='https://files.coinmarketcap.com/static/img/coins/32x32/"+value.id+".png' width='32' height='32'></div>";
                    html +="    <div class='item-inner'>";
                    html +="      <div class='item-title-row'>";
                    html +="        <div class='item-title'>"+value.rank+" - "+value.name+" ("+value.symbol+")</div>";
                    html +="      </div>";
                    html +="      <div class='item-subtitle' style='color:#999;font-size:12px;'>"+value.market_cap_usd+" USD</div>";
                    html +="      <div class='item-subtitle' style='color:#ccc;font-size:11px;'>"+value.price_usd+" USD ("+change+")</div>";
                    html +="    </div>";
                    html +="  </div>";
                    html +="</li>";
                });
                    html +="</ul>";
                $("#marketcap-list").html(html);

                myApp.initImagesLazyLoad('.view-marketcap .page-content');

                var mySearchbar = $$('.searchbar')[0].f7Searchbar;
                
            }
        });
    }

    function getNews(){
        $("#news-list").html('<div style="text-align:center;margin:30px;"><span class="preloader preloader-white"></span></div>');
        $.ajax({
            url:'https://pool-stats.herokuapp.com/news.php',
            type:'get',
            dataType:'json',
            cache:true,
            success:function(data){
                var html="<ul>";
                $.each(data.channel.item, function(index, value) {
                    html +="<li>";
                    html +="  <a href='"+value.link+"' class='item-link item-content'>";
                    html +="    <div class='item-inner'>";
                    html +="      <div class='item-title-row'>";
                    html +="        <div class='item-title'>Siam Blockchain</div>";
                    html +="        <div class='item-after'></div>";
                    html +="      </div>";
                    html +="      <div class='item-subtitle'>"+value.pubDate+"</div>";
                    html +="      <div class='item-text' style='color:#ccc'>"+value.title+"</div>";
                    html +="    </div>";
                    html +="  </a>";
                    html +="</li>";
                });
                    html +="</ul>";
                $("#news-list").html(html);             
            }
        });
    }
</script>
</body>
</html>
