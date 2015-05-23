<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
			
	<div id="content" class="row" role="main">
		<div class="row">
			<div class="eightcol">
				
					<div class="eightcol main-banner" role="banner">
					<a href="/blog/category/stationschef/"><?php echo do_shortcode('[slider id="1930" name="Stationschef"]'); ?></a>
					<?php //echo do_shortcode('[parallaxcontentslider]'); ?>
					</div>
				<?php dynamic_sidebar( 'sidebar-fronttop' ); ?>
						
			</div>

			<aside class="fourcol last social">
				
				<div class="widget-counter col3">
					<?php /* TWITTER/FACEBOOK COUNTER */
					$fb_username = 'pinguinradio';
					$tw_username = 'PinguinRadio'; 
					
					$fb = @json_decode(file_get_contents('/var/www/vhosts/pinguinradio.com/httpdocs/_assets/php/tweets/fbapi.json'));
					$fb_fans = number_format($fb->likes); 
					
					
					$tw =  @json_decode(file_get_contents('/var/www/vhosts/pinguinradio.com/httpdocs/_assets/php/tweets/twitterapi.json'));
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
								<span><?=$fb_fans;?></span>
								<small>Fans</small>
							</a>
						</li>
					</ul>
				</div>
				<div class="frontpage-header-ad">
					<?php
					function On_off_air(){ 
					    $hour = date("G")+2; 
					    
					        if($hour == 9){ 
					            $airtime = "<a href=\"http://www.inuteq.com/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/inuteq-9-10.jpg\"></a>";
					        }else if($hour == 10){ 
					            $airtime = "<a href=\"http://www.inuteq.com/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/inuteq-9-10.jpg\"></a>";
					        }else if($hour == 11){ 
					            $airtime = "<a href=\"http://www.maseto.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/maseto-11.jpg\" height=\"185\"></a>";
					        }else if($hour == 12){ 
					            $airtime = "<a href=\"http://www.cerios.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/cerios-14.jpg\"></a>";
					        }else if($hour == 15){
						        	$airtime = "<a href=\"http://www.vest.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/vest-15.gif\"></a>";
					        }else if($hour == 16){
						        	$airtime = "<a href=\"http://pinguinradio.com/pinguin-radio-top-150-aller-tijden/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/1.jpg\"></a>";
					        }else if($hour == 17){ 
					            $airtime = "<a href=\"http://pinguinradio.com/pinguin-radio-top-150-aller-tijden/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/2.jpg\"></a>";
					        }else if($hour == 20){ 
					            $airtime = "<a href=\"http://www.bestofwines.nl/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/wines-20.jpg\"></a>";
					        }else if($hour == 19){ 
					            $airtime = "<a href=\"http://pinguinradio.com/pinguin-radio-top-150-aller-tijden/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/3.jpg\"></a>";
					        }else if($hour == 21){ 
					            $airtime = "<a href=\"http://pinguinradio.com/pinguin-radio-top-150-aller-tijden/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/4.jpg\"></a>";
					        }else { 
					            $airtime = "<a href=\"http://pinguinradio.com/pinguin-radio-top-150-aller-tijden/\" target=\"_blank\"><img src=\"/_assets/img/_sponsors/1.jpg\"></a>"; 
					        } 
					    return $airtime; 
 					} 
					 echo On_off_air();
					// echo date("G");
					?>
				
				</div>
			</aside>
		</div>
		<div class="row" style="padding: 20px 0 0 0">						
			<?php get_sidebar('front'); ?>
		</div>
	</div><!-- #content -->


<?php get_footer(); ?>