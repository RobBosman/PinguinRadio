<?php
/**
 * The sidebar containing the front page widget areas.
 *
 * If no active widgets in either sidebar, they will be hidden completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * The front page widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
 
 
if ( ! is_active_sidebar( 'sidebar-frontleft' ) && ! is_active_sidebar( 'sidebar-frontright' ) )
	return;

// If we get this far, we have widgets. Let do this.
?>
	<?php if ( is_active_sidebar( 'sidebar-frontleft' ) ) : ?>
	<section class="eightcol front-widgets front-left">
		<?php dynamic_sidebar( 'sidebar-frontleft' ); ?>
	</section><!-- .first -->
	<?php endif; ?>
	
	<aside class="last fourcol front-widgets">
	
	 

		<section class="donor-ads" style="background:none!important;">
			<div>
				<center>
				<article><a href="/acties/doneren" class="donor-button"><span>Doneer aan Pinguin Radio! Voor supervette internet radio!</span></a></article>
				</center>
				
			</div>
		</section>

			<?php //if( function_exists( 'pro_ad_display_adzone' ) ) echo pro_ad_display_adzone( 2 ); ?>
		<a href="/adverteren/pixelpage"><img src="http://pinguinradio.com/wp-content/uploads/pixelpage-button.jpg" alt="adverteren" style="margin-bottom: 20px"></a>
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
		  
			
		
	</aside><!-- .second -->
