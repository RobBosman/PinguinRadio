<!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->

<head id="www.pinguinradio.com">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?php wp_title( '|', true, 'right' );?></title>
	
	<meta name="title" content="Pinguin Radio, no bullshit great music.">
	
	<meta name="author" content="www.marcelvangastel.com">
	<meta name="Copyright" content="Copyright 2013 Marcel van Gastel. All Rights Reserved.">

	<meta name="DC.title" content="Pinguin Radio">
	<meta name="DC.subject" content="Alternative online radio, no bullshit, just great music.">
	<meta name="DC.creator" content="Marcel van Gastel">
	
	<meta property='fb:app_id' content='138630079625440'>  
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<link rel="shortcut icon" href="/_assets/img/favicon.ico">
	<link rel="apple-touch-icon" href="/_assets/img/apple-touch-icon.png">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Jockey+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/_assets/css/reset.css">
	<link rel="stylesheet" href="/_assets/css/style.css?1.02">
	<link rel="stylesheet" href="/_assets/css/responsive.css">
		
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="/_assets/css/ie8.css?1.0" />
	<![endif]-->
		
	<script src="/_assets/js/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="/_assets/js/jplayer/jquery.jplayer.js"></script>
	
	
	
<?php //wp_head();?>
	

		
<? /*
DIT STAAT IN DE WP_HEAD, COMPRIMEREN BIJ PRODUCTIE	
*/?>

<? // JS LOAD PAGES ?>

	<script type="text/javascript">
		checkjQuery = false;
		jQueryScriptOutputted = false;
		
		var AAPL_content = 'content';
		var AAPL_search_class = 'searchform';		
		var AAPL_ignore_string = new String('#, /wp-, .pdf, .zip, .rar'); 
		var AAPL_ignore = AAPL_ignore_string.split(', ');
		var AAPL_track_analytics = false		
		var AAPL_scroll_top = true		
		var AAPL_warnings = false;
		
		function initJQuery() {
			if (checkjQuery == true) {
				if (typeof(jQuery) == 'undefined') {
				
					if (! jQueryScriptOutputted) {
						jQueryScriptOutputted = true;
						document.write('<scr' + 'ipt type="text/javascript" src="http://pinguinradio.com/wp-content/plugins/advanced-ajax-page-loader/jquery.js"></scr' + 'ipt>');
					}
					setTimeout('initJQuery()', 50);
				}
			}
		}
		initJQuery();
	</script>
	
	<script type="text/javascript" src="http://pinguinradio.com/wp-content/plugins/advanced-ajax-page-loader/ajax-page-loader.js"></script>
	
	<script type="text/javascript">
		var AAPLsiteurl = "http://pinguinradio.com";
		var AAPLhome = "http://pinguinradio.com";

		var AAPLloadingIMG = jQuery('<img/>').attr('src', 'http://pinguinradio.com/wp-content/uploads/AAPL/loaders/SMALL - Circle Ball.gif');
		var AAPLloadingDIV = jQuery('<div/>').attr('style', 'display:none;').attr('id', 'ajaxLoadDivElement');
		AAPLloadingDIV.appendTo('body');
		AAPLloadingIMG.appendTo('#ajaxLoadDivElement');
		
		//Loading/Error Code
		var str = "<center>\r\n\t<p style=\"text-align: center !important; font-family: Jockey One, sans-serif; font-size:30px; \">Loading... Please Wait...<\/p>\r\n\t<p style=\"text-align: center !important;\">\r\n\t\t<img src=\"{loader}\" border=\"0\" alt=\"Loading Image\" title=\"Please Wait...\" \/>\r\n\t<\/p>\r\n<\/center>";
		var AAPL_loading_code = str.replace('{loader}', AAPLloadingIMG.attr('src'));
		str = "<center>\r\n\t<p style=\"text-align: center !important;\">Error!<\/p>\r\n\t<p style=\"text-align: center !important;\">\r\n\t\t<font color=\"red\">There was a problem and the page didnt load.<\/font>\r\n\t<\/p>\r\n<\/center>";
		var AAPL_loading_error_code = str.replace('{loader}', AAPLloadingIMG.attr('src'));
	</script>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-26035294-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
	
<? /*
TOT HIER
*/?>	
	
<!-- BEGIN Graadmeter -->
    <link rel="stylesheet" type="text/css" href="/wp-content/themes/Pinguinradio/css/graadmeter.css" />
    <script type="text/javascript" language="javascript" src="/wp-content/themes/Pinguinradio/js/graadmeter.js"></script>
<!-- END Graadmeter -->
</head>
<body <?php body_class(); ?> id="<?php echo get_option('current_page_template'); ?>">



<?php 
//RANDOM BACKGROUND 
	$imglist='';
	$img_folder = "_assets/img/global/layout/backgrounds/";
	
	mt_srand((double)microtime()*1000);
	
	$imgs = dir($img_folder);
	
	while ($file = $imgs->read()) {
		if (eregi("gif", $file) || eregi("jpg", $file) || eregi("png", $file))
			$imglist .= "$file ";
	
	} closedir($imgs->handle);
	
	$imglist = explode(" ", $imglist);
	$no = sizeof($imglist)-2;
	
	$random = mt_rand(0, $no);
	$image = $imglist[$random];
	
	echo '<img src="/'.$img_folder.$image.'" class="background-image" border=0>';
//EINDE RANDOM BACKGROUND ?>

<div id="background">

<!-- TOP HEADER -->	
	<header class="header">
	  <section class="row header-row">
			<hgroup class="logo">
				<h1><a href="/" rel="home"><span>Pinguin Radio, web and online radio, no bullshit great music</span></a></h1>
			</hgroup>
			<div class="pinguin-player">
			
				<iframe src="/_assets/php/player/player-pinguin.php" style="border:0px #FFFFFF none;" name="Player" scrolling="no" frameborder="0" marginheight="0px" marginwidth="0px" height="98px" width="100%"></iframe> 
				
				
	<?php //BANNR ?>
		
		<script>
						var bannerHashPrev = '';
					function updateBanner() {
						var randomnumbar=Math.floor(Math.random()*1000000000000000000000010001);
							// Fetch banner information
				      $.get('/_assets/php/bannr/player_getbannr_local.php?foo='+randomnumbar, function(returnData) {
				      	if (typeof returnData.success != 'undefined' && returnData.success == true) {
									var bannerIcon	= returnData.data.icon;
									var bannerImage	= returnData.data.image;
									var bannerLink	= returnData.data.link;
									var bannertext	= returnData.data.text;
									var foreground	= returnData.data.foreground;
									var background	= returnData.data.background;
									var bannerHash	= returnData.data.hash;
									
									bannerElement			= $('#bannerWrapper');
									
									if (bannerHash == bannerHashPrev) {
										// Zelfde banner opgehaald, niets doen.
										//console.log('Banner hetzelfde laten');
									}
									else {
										// Nieuwe banner, updaten die handel
										//console.log('Banner updaten');
										bannerHashPrev = bannerHash;
										bannerElement.fadeOut(function(){
											var bannertextHtml = '';
											
											bannerBgElement   = $('#bannerBg');
											bannerIconElement = $('#bannerIcon');
											bannerTextElement	= $('#bannerText');
											bannerImgElement	= $('#bannerImg');
											bannerLinkElement	= $('#bannerLink');
											
											// Set background color
											if (background != '') {
												bannerBgElement.css('background-color',background);
												//bannerTextElement.css('background-color',background);
											}
											else {
												bannerBgElement.css('background-color','');
												//bannerTextElement.css('background-color','');
											}
											
											// Set foreground (text) color
											if (foreground != '') {
												bannerElement.css('color',foreground);
												bannerTextElement.css('color',foreground);
												bannerLinkElement.css('color',foreground);
											}
											else {
												bannerElement.css('color','');
												bannerTextElement.css('color','');
												bannerLinkElement.css('color','');
											}
											// Add text
											if (bannertext != '') {
												bannerTextElement.html(bannertext);
												bannerTextElement.show();
												//alert(bannertext.length);
												//countText(bannertext);
				  						}
				  							else {
				  							 bannerTextElement.hide();
				  							}
											// Add image
											if (bannerImage != '') {
												bannerImgElement.attr('src',bannerImage);
												if(bannertext != '') {
													bannerImgElement.attr('alt',bannertext);
												}
												else {
													bannerImgElement.attr('alt','Banner');
												}
												bannerImgElement.show();
											}
											else {
												bannerImgElement.hide();
											}
											// Add icon
											if (bannerIcon != '') {
												bannerIconElement.attr('src',bannerIcon);
												if(bannertext != '') {
													bannerIconElement.attr('alt',bannertext);
												}
												else {
													bannerIconElement.attr('alt','Banner');
												}
												bannerIconElement.show();
											}
											else {
												bannerIconElement.hide();
											}
											
											// Add link
											bannerLinkElement.attr('href',bannerLink);
											if (bannerLink != '') {
												bannerLinkElement.off('click.bannerlink');
												bannerLinkElement.on('click.bannerlink', function() {
													window.open($(this).attr('href'));
													return false;
												});
												bannerLinkElement.css('cursor','pointer');
											}
											else {
												bannerLinkElement.off('click.bannerlink');
												bannerLinkElement.on('click.bannerlink', function() { return false; });
												bannerLinkElement.css('cursor','default');
											}
											
											bannerElement.fadeIn();
										});
									}
				      	}
				      },'json');
						}
						
						    
				    updateBanner();
				      updateBannerInterval = setInterval('updateBanner()',10000);

				</script>	
			
			<figure class="bannr">
			  <div id="bannerWrapper" style="width:425px!important; height:40px!important;">
					<a id="bannerLink" href="#" style="text-decoration:none;">
					  <div id="bannerBg" style="position:absolute; z-index:1; width:425px; height: 40px;"></div>
						<div class="horizontal_scroller" style="width: 355px; display:block; position:absolute; z-index:3; padding:10px 10px 0 10px; background:none; margin:0 0 0 46px">
						  <!--[if IE]>
						  <marquee>
						  <![endif]-->
						  <div id="bannerText" class="scrollingtext" style="background:none; text-decoration:none;">
						  </div>
						  <!--[if IE]>
						  </marquee>
						  <![endif]-->
						</div>
						<img id="bannerIcon" style="height:38px; background:none; position:absolute; z-index:4; margin: 1px 0 0 1px" src="">
						<img id="bannerImg" style="height:40px; position:absolute; z-index:2; background:none;" src="">
					</a>
				</div>
			</figure>
				
			</div>			
			
			<div class="languages-flags">
				<!--<a href="http://www.pinguinradio.com/en/"><img src="/_assets/img/content/en_flag.jpg"></a>-->
				<a href="http://www.pinguinradio.com/"><img src="/_assets/img/content/nl-flag.jpg"></a>
			</div>	
			
	  </section>	
			
	</header>
	
	<?php //menu ?>
	
	<div class="menu-container ">
		<div class="menu-container-inside row">
			<div class="popup-container">
				<a class="popup-play" href="#" onclick="window.open('/_assets/php/popup-player/pinguin-player-popup.php','PinguinRadioPlayer',
		'width=445,height=270,scrollbars=no,toolbar=no,location=no'); return false; _gaq.push(['_trackEvent', 'Player', 'Popup', 'Open'])">Popup Player</a>
			</div>
		<?php
			wp_nav_menu( array( 
				'theme_location' => 'primary', 
				'container' => 'nav',
				'container_id' => 'menu',
				'menu_class' => 'row',
				) ); 
				?>
				
		</div>
	</div>
	
						
		<select id="select_menu" onchange="location = this.value">
			<option value="">Select Page</option>
			        <option value="/nieuws">Nieuws</option>
			        <option value="/concertagenda">Concertagenda</option>
			        
			        <option value="/radioagenda">Radio Agenda</option>
			        <option value="/radioagenda/deze-week">&nbsp;&nbsp;&nbsp;&nbsp;Deze week</option>
			        <option value="/radioagenda/aardschok">&nbsp;&nbsp;&nbsp;&nbsp;Aardschok</option>
			        
			        <option value="/playlist">Playlist</option>
			        
			        <option value="/programmas">Programma's</option>
			        <option value="/graadmeter">&nbsp;&nbsp;&nbsp;&nbsp;De Graadmeter</option>
			        <option value="/programmas/bazzopdebuzz-met-de-stationschef">&nbsp;&nbsp;&nbsp;&nbsp;BazzOpDeBuzz met de Stationschef</option>
			        <option value="/programmas/radio-cortonville">&nbsp;&nbsp;&nbsp;&nbsp;Radio Cortonville</option>
			        <option value="/programmas/festivalinfo-live">&nbsp;&nbsp;&nbsp;&nbsp;Festivalinfo Live</option>
			        <option value="/programmas/club-casablanca">&nbsp;&nbsp;&nbsp;&nbsp;Club Casablanca</option>
			        <option value="/programmas/frisse-wind">&nbsp;&nbsp;&nbsp;&nbsp;Frisse wind</option>
			        <option value="/programmas/zero-gravity">&nbsp;&nbsp;&nbsp;&nbsp;Zero Gravity</option>
			        <option value="/programmas/johannes-de-doper">&nbsp;&nbsp;&nbsp;&nbsp;Johannes &amp; De Doper</option>
			        <option value="/programmas/2-minuten-show">&nbsp;&nbsp;&nbsp;&nbsp;2 minuten show</option>
			        <option value="/programmas/aardschok">&nbsp;&nbsp;&nbsp;&nbsp;Aardschok</option>
	
			        <option value="/pinguinradio">Pinguinradio</option>
			        <option value="/pinguinradio/wie-en-wat-is-pinguin-radio">&nbsp;&nbsp;&nbsp;&nbsp;Wie en wat is Pinguin Radi</option>
			        <option value="/pinguinradio/hoe-kan-ik-pinguinradio-nl-beluisteren">&nbsp;&nbsp;&nbsp;&nbsp;Hoe kan ik Pinguinradio.nl beluisteren</option>
			        <option value="/pinguinradio/contact">&nbsp;&nbsp;&nbsp;&nbsp;Contact</option>
			        <option value="/pinguinradio/leveringsvoorwaarden-shop">&nbsp;&nbsp;&nbsp;&nbsp;Leveringsvoorwaarden shop</option>		        
			   
			        <option value="/adverteren">Adverteren</option>
			        <option value="/shop">Shop</option>
			    </select>
<!-- END TOP MAIN NAV -->

	<div id="main" class="container">
		
	
	
	