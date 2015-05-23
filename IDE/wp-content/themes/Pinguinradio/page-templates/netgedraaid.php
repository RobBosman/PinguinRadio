<?php
/**
 * Template Name: Net gedraaid Template
 *
 * Description: Net gedraaid template
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
		
		<section id="content" class="row" role="main">			
			<?php get_sidebar('left'); ?>
				
		<article class="sevencol content-bg" id="post-61">
			<header class="entry-header">
				<h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title;?></h3>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			
			<?php
			
			// Variabelen
			
			  $tijd = date("H:i:s"); 
			  $dag_vd_week = date("w");
			  $maand_vh_jaar = date("n")-1; 
			  $dedag = date("j"); 
			  $jaar = date("Y"); 
			  $uur = explode(":", $tijd); 
			
			  $dagen = array('zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag');
			  $dagen_play = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'); 
			  $maanden = array('januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december'); 
			  $dag = $dagen[$dag_vd_week];
			  $dagplay = $dagen_play[$dag_vd_week];
			  $maand = $maanden[$maand_vh_jaar];
			
			  echo "<p>Hieronder de playlist van  ".$dag." ".$dedag." ".$maand." ".$jaar.".</p>"; 

			

				if ( is_page( 'net-gedraaid' ) ) {    
		
				//XML 1	
						$xml = simplexml_load_file("http://www.pinguinradio.com/streams/pinguinradio/playlist/".$dagplay."-".($uur[0]).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
			
						echo "<h4>Playlist van ".$dag." - ".($uur[0]).":00 tot ".($uur[0]+1).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
						
						$xml2 = simplexml_load_file("http://www.pinguinradio.com/streams/pinguinradio/playlist/".$dagplay."-".(date('H', time() - 3600)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 3600)).":00 tot ".($uur[0]).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml2->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
							$xml3 = simplexml_load_file("http://www.pinguinradio.com/streams/pinguinradio/playlist/".$dagplay."-".(date('H', time() - 7200)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 7200)).":00 tot ".($uur[0]-1).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml3->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
							$xml4 = simplexml_load_file("http://www.pinguinradio.com/streams/pinguinradio/playlist/".$dagplay."-".(date('H', time() - 10800)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 10800)).":00 tot ".($uur[0]-2).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml4->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";

			//EINDE PLAYLIST
			
			
			} elseif ( is_page( 'pinguin-classics' ) ) {	
				    
				    //XML 1	
						$xml = simplexml_load_file("http://www.pinguinradio.com/streams/classics/playlist/".$dagplay."-".($uur[0]).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
			
						echo "<h4>Playlist van ".$dag." - ".($uur[0]).":00 tot ".($uur[0]+1).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
						
						$xml2 = simplexml_load_file("http://www.pinguinradio.com/streams/classics/playlist/".$dagplay."-".(date('H', time() - 3600)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 3600)).":00 tot ".($uur[0]).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml2->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
							$xml3 = simplexml_load_file("http://www.pinguinradio.com/streams/classics/playlist/".$dagplay."-".(date('H', time() - 7200)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 7200)).":00 tot ".($uur[0]-1).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml3->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
							$xml4 = simplexml_load_file("http://www.pinguinradio.com/streams/classics/playlist/".$dagplay."-".(date('H', time() - 10800)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 10800)).":00 tot ".($uur[0]-2).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml4->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";

			//EINDE PLAYLIST

				    
				
				} elseif ( is_page( 'aardschok' ) ) { 
				    
				    //XML 1	
						$xml = simplexml_load_file("http://www.pinguinradio.com/streams/aardschok/playlist/".$dagplay."-".($uur[0]).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
			
						echo "<h4>Playlist van ".$dag." - ".($uur[0]).":00 tot ".($uur[0]+1).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
						
						$xml2 = simplexml_load_file("http://www.pinguinradio.com/streams/aardschok/playlist/".$dagplay."-".(date('H', time() - 3600)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 3600)).":00 tot ".($uur[0]).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml2->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
							$xml3 = simplexml_load_file("http://www.pinguinradio.com/streams/aardschok/playlist/".$dagplay."-".(date('H', time() - 7200)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 7200)).":00 tot ".($uur[0]-1).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml3->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";
						
							$xml4 = simplexml_load_file("http://www.pinguinradio.com/streams/aardschok/playlist/".$dagplay."-".(date('H', time() - 10800)).".XML", "SimpleXMLElement", LIBXML_NOCDATA);
						
						echo "<h4>Playlist van ".$dag." - ".(date('H', time() - 10800)).":00 tot ".($uur[0]-2).":00</h4>";
						echo "<div class=\"playlist-padding\"><ul class=\"playlist-netgedraaid\">";	   
						foreach($xml4->AppSpecificInfo->PlaylistInfo->children() as $Item){
								if($Item->Interpret != '' and $Item->Interpret != 'Sweep' and substr($Item->Interpret, 0 ,5) != 'Promo' and substr($Item->Interpret, 0 ,2) != 'WJ' and substr($Item->Interpret, 0 ,2) != 'HJ'and $Item->Interpret != 'Graadmeter' and $Item->Interpret != 'Sponsor Spot' and $Item->Interpret != 'promo lang' and $Item->Interpret != 'Promo kort' and $Item->Interpret != 'Stationschef Promo' and $Item->Title != 'Stationschef' and substr($Item->Interpret, 0 ,4) != 'KVMI' and $Item->Interpret != 'NBGM' and $Item->Interpret != 'DIPR' and $Item->Interpret != 'PRNBGM' and $Item->Interpret != 'Pinguin Radio' and substr($Item->Interpret, 0 ,9) != 'Billboard' and substr($Item->Interpret, 0 ,7) != 'PINGUIN' and $Item->Title != 'Cocos'){
									echo "<li><b>" .$Item->Interpret. "</b>";
								 echo $Item->Title;
								 echo "</li>";
			
								} else {}
						}
						echo "</ul></div>";

			//EINDE PLAYLIST
				    
				
				} else { 
				    //
				}	
				
				?>
			
									
					
		</article>
				
			<?php get_sidebar('right'); ?>
		</section><!-- #content -->

<?php get_footer(); ?>