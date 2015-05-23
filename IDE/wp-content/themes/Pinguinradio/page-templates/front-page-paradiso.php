<?php
/**
 * Template Name: Front Page Paradiso Template
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
			<a href="/acties/pinguins-in-paradiso"><img src="/_assets/img/actie/laatste-banner-voor-pip.gif"></a>
		</div>
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
					$tw_followers = number_format($tw->followers_count);
					?>
					
					<ul>
						<li class="rss-subscribers">
							<a href="http://www.pinguinradio.com/feed/" target="_blank">
								<span>Subscribe</span>
								<small>To RSS Feed</small>
							</a>
						</li>
						<li class="twitter-followers">
							<a href="http://www.twitter.com/PinguinRadio" target="_blank">
								<span><?=$tw_followers;?></span>
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
				<div class="frontpage-header-ad" style="">
					<a href="/acties/pinguins-in-paradiso"><img src="/_assets/img/actie/koophierkaarten.jpg" style="position:absolute;"></a>
			</aside>
		</div>
		<div class="row" style="padding: 20px 0 0 0">						
			<?php get_sidebar('front'); ?>
		</div>
	</div><!-- #content -->


<?php get_footer(); ?>