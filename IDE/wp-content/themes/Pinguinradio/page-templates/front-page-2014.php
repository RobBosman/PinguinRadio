<?php
/**
 * Template Name: Front Page Template 2014
 *
 * Description: 
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
			
	<div id="content" class="row" role="main">
		<div class="row">
				<?php //dynamic_sidebar( 'sidebar-frontnews' ); ?>
                    
                    <div class="widget-home-small head-widget graad-widget" style="height:600px;">
                        <h3 class="widget-title">Graadmeter</h3>
                        <img class="graadmeter-image" src="http://pinguinradio.com/_assets/img/content/graadmeter.jpg">
                        
                    <?php /* GRAADMETER SCRIPTS */
                        
                        global $wpdb;
                        $wpdb->show_errors();
                        
                        // Toon lijst en mogelijkheid tot stemmen.
                        $rows = $wpdb->get_results("SELECT * FROM `ext_graadmeter` ORDER BY `positie` ASC LIMIT 0, 19");
                        $rows_top41 = array();
                        $rows_exit = array();
                        $rows_tip10 = array();
                        foreach ($rows as $row) {
                            if ($row->lijst == 'top41') {
                                $rows_top41[] = $row;
                            } else if ($row->lijst == 'exit') {
                                $rows_exit[] = $row;
                            } else if ($row->lijst == 'tip10') {
                                $rows_tip10[] = $row;
                            }
                        }
                        
                        // Get the ContextPrefix. Use the RequestURI and strip-off anything after the last slash, including queryString parameters.
                        $CONTEXT_PREFIX = preg_replace('|[^/]*$|', '', $_SERVER['REQUEST_URI']);
                        $BASE_URL = preg_replace('|/graadmeter/|', '/', $CONTEXT_PREFIX);
                        
                        ?>
                        <a href="/graadmeter">
                         <table cellspacing="2" class="graadhome">
                       
                            <tbody>
                                <?php foreach ($rows_top41 AS $row) {
                                    $positie_vw = $row->positie_vw == 0 ? 'nw' : $row->positie_vw * -1;
                                    $ijsbreker = ($row->ijsbreker == "J" ? ($row->positie_vw == 0 ? "IJSBREKER" : "ex-ijsbreker") : "&nbsp;");
                                    $ref = $row->ref;
                                    
                                    echo "<tr>";
                                    echo "<td align='right'>" . $row->positie * -1 . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                                    echo "  <td class='graadmeter-front-td'><b>$row->artiest</b>
                                                <br>
                                                $row->track
                                            </td>";
                                    echo "</tr>";
                                } ?>
                            </tbody>
                        </table>
                        
                        <a href="/graadmeter-beluisteren/" class="widget-home-small" style="display: block;
padding: 14px 0 14px 0;
text-align: center;
font-size: 16px;
text-transform: uppercase;
font-weight: 900;"><b>Luister hier de laatste uitzending na</b></a></a>
                        <div style="clear:both;"></div>
                    </div>
				
					<div class="widget-home-central main-banner stationschef-widget" role="banner">
					<a href="/blog/category/stationschef/"><?php echo do_shortcode('[slider id="1930" name="Stationschef"]'); ?></a>
					<?php //echo do_shortcode('[parallaxcontentslider]'); ?>
					</div>

			<aside class="widget-home-right last social">
				
				<div class="widget-counter col3">
					<?php /* TWITTER/FACEBOOK COUNTER */
					$fb_username = 'pinguinradio';
					$tw_username = 'PinguinRadio'; 
					
					$fb = @json_decode(file_get_contents('/home/pinguin/domains/pinguinradio.com/public_html/_assets/php/tweets/fbapi.json'));
					$fb_fans = number_format($fb->likes); 
					
					
					$tw =  @json_decode(file_get_contents('/home/pinguin/domains/pinguinradio.com/public_html/_assets/php/tweets/twitterapi.json'));
					?>
					
					<ul>
						<li class="rss-subscribers">
							<a href="http://www.pinguinradio.eu/feed/" target="_blank">
								<span>Subscribe</span>
								<small>To RSS Feed</small>
							</a>
						</li>
						<li class="twitter-followers">
							<a href="http://www.twitter.com/PinguinRadio" target="_blank">
								<span><?php echo $tw[0]->user->followers_count ; ?></span>
								<small>Followers</small>
							</a>
						</li>
						<li class="facebook-fans">
							<a href="http://facebook.com/pinguinradio" target="_blank">
								<span><?php echo $fb_fans;?></span>
								<small>Fans</small>
							</a>
						</li>
					</ul>
				</div>
				<div class="frontpage-header-ad">
				    <iframe src="/_assets/php/sponsor/reload.php" style="border:0px #FFFFFF none;" name="sponsor" scrolling="no" frameborder="0" marginheight="0px" marginwidth="0px" height="185px" width="350px"></iframe>
				    <?php /*
				    <script>
				        function updateSponsor(){
    				        var currentHour = new Date().getHours();
    				        //console.log(currentHour);
    				        
    				        if(currentHour == 9){ 
    				            $("#imageSponsor").attr('src', '/_assets/img/_sponsors/1.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 10) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 11) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/3.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 12) {
    				            $("#imageSponsor").attr('src', '/_assets/img/_sponsors/kf.jpg');
    				            $("#linkSponsor").attr('href', 'http://www.kroepoekfabriek.nl/');        				        
    				        } else if(currentHour == 13) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/cerios.jpg');
    				            $("#linkSponsor").attr('href', 'http://www.cerios.nl/');
    				        } else if(currentHour == 14) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/volt.jpg');
    				            $("#linkSponsor").attr('href', 'http://www.poppodium-volt.nl/');
    				        } else if(currentHour == 15) {
    				            $("#imageSponsor").attr('src', '/_assets/img/_sponsors/vest.gif');
    				            $("#linkSponsor").attr('href', 'http://www.vest.nl/');        				        
    				        } else if(currentHour == 16) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/wines-20.jpg');
    				            $("#linkSponsor").attr('href', 'http://www.bestofwines.nl/');
    				        } else if(currentHour == 17) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/dhf.png');
    				            $("#linkSponsor").attr('href', 'http://dehostingfirma.nl/');
    				        } else if(currentHour == 18) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 19) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 20) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 21) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 22) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 23) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else if(currentHour == 24) {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');
    				        } else {
        				        $("#imageSponsor").attr('src', '/_assets/img/_sponsors/2.jpg');
    				            $("#linkSponsor").attr('href', '/adverteren');

    				        }
    				        
				        }

                        updateBannerInterval = setInterval('updateSponsor()',60000);
                        window.onload = function () { updateSponsor(); }
                    </script>
                    
                    <a id="linkSponsor" href="" target="_blank"><img id="imageSponsor" src=""></a>
                    */ ?>
					<?php 
					/*function On_off_air(){ 
					    $hour = date("G")+2; 
					   
					        if($hour == 12){ 
					            $airtime = "<a href=\"http://www.kroepoekfabriek.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/cerios.jpg\"></a>";
					        }else if($hour == 13){ 
					            $airtime = "<a href=\"http://www.cerios.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/kf.jpg\"></a>";
					        }else if($hour == 14){
						        	$airtime = "<a href=\"http://www.poppodium-volt.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/volt.nl\"></a>";
					        }else if($hour == 15){
						        	$airtime = "<a href=\"http://www.vest.nl\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/vest.gif\"></a>";
					        }else if($hour == 16){ 
					            $airtime = "<a href=\"http://www.bestofwines.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/wines-20.jpg\"></a>";
					        }else if($hour == 17){ 
					            $airtime = "<a href=\"http://www.dehostingfirma.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/dhf.png\"></a>";
					        }else { 
					            $airtime = "<a href=\"http://pinguinradio.com/adverteren/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/1.jpg\"></a>"; 
					        } 
					    return $airtime; 
 					} 
					 echo On_off_air();
					 */
					?>
                    
                    <?php /* <a href="http://pinguinradio.com/blog/stvincent/"><img src="/_assets/img/_sponsors/stvincent.jpg"></a> */?>
				</div>
			</aside>
            <section class="widget-home-central front-widgets front-left">
                <?php dynamic_sidebar( 'front-centre' ); ?>
            </section><!-- .first -->
            
            <?php /* ROW 2 & 3 */ ?>

<?php /* END ROW 2 ?>

            
<?php /* SIDEBAR */ ?>            
            <aside class="widget-home-right right-side">
	
	 

            		<section class="donor-ads" style="background:none!important; position:relative; height:200px;">
            			<div>
            				<article>
            				    <a href="/acties/doneren" class="donor-button"><span>Doneer aan Pinguin Radio! Voor supervette internet radio!</span></a>
                                <a href="/acties/vrienden-van-pinguin" class="ei-button"><span>Doneer aan Pinguin Radio! Voor supervette internet radio!</span></a>
            				</article>
            			</div>
            		</section>
                    <a href="/shop" target="_blank"><img src="/_assets/img/content/shop-banner.gif" style="margin-bottom: 20px"></a>
                    <?php //if( function_exists( 'pro_ad_display_adzone' ) ) echo pro_ad_display_adzone( 2 ); ?>
            		<a href="/adverteren/vrienden-van-pinguin-radio-bedankt"><img src="/_assets/img/content/vrienden.png" alt="adverteren" style="margin-bottom: 20px"></a>
            		<a href="/partners"><img src="/_assets/img/content/partners.png" alt="partners" style="margin-bottom: 20px"></a>
            		<?php dynamic_sidebar( 'sidebar-frontright' ); ?>
            	
            	<style>
            		.timeline {
            margin-bottom: 10px;
            background-color: none!important;
            border-radius: 5px;
            }
            .customisable-border {
            border: none!important;
            }
            	</style>
            		  
            		  <section id="twitter-2" class="widget widget_twitter">
            		  	<div>
            			  	<h3 class="widget-title"><span class="twitterwidget twitterwidget-title">Pinguin Radio laatste tweet</span></h3>
            			  </div>
            			  <a class="twitter-timeline" href="https://twitter.com/search?q=pinguinradio" data-widget-id="365466486984306689">Tweets about "pinguinradio"</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            
            			  
            			
            			</section>
            		  
            			
            		
            	</aside>
<?php /* END SIDEBAR */ ?>
    <div class="center-home">

    <?php dynamic_sidebar( 'front-row2' ); ?>
    <?php dynamic_sidebar( 'front-row3' ); ?>
    <?php dynamic_sidebar( 'front-row4' ); ?>
    </div> 

            	
		</div>
		<?php /*
		<div class="row" style="padding: 20px 0 0 0">						
			<?php //get_sidebar('front'); ?>
		</div>
		*/?>
	</div><!-- #content -->


<?php get_footer(); ?>