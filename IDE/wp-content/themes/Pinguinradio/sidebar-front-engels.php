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
 
 
if ( ! is_active_sidebar( 'sidebar-frontleft-eng' ) && ! is_active_sidebar( 'sidebar-frontright-eng' ) )
	return;

// If we get this far, we have widgets. Let do this.
?>
	<?php if ( is_active_sidebar( 'sidebar-frontleft-eng' ) ) : ?>
	<section class="eightcol front-widgets front-left">
		<?php dynamic_sidebar( 'sidebar-frontleft-eng' ); ?>
	</section><!-- .first -->
	<?php endif; ?>
	
	<aside class="last fourcol front-widgets">
		<?php dynamic_sidebar( 'sidebar-frontright-eng' ); ?>
		  <script src="http://widgets.twimg.com/j/2/widget.js"></script> 
		  <style type="text/css">
		  	.twtr-hd	{ display: none}
		  </style>
		  
		  <section id="twitter-2" class="widget widget_twitter">
		  	<div>
			  	<h3 class="widget-title"><span class="twitterwidget twitterwidget-title">Pinguin Radio latest tweet</span></h3>
			  </div>
			  <script>
			new TWTR.Widget({
			  version: 2,
			  type: 'search',
			  search: 'pinguinradio',
			  interval: 7500,
			  title: '',
			  subject: '',
			  width: 240,
			  height: 250,
			  theme: {
			    shell: {
			      color: '#ffffff',
			      background: 'none'
			    },
			    tweets: {
			      background: 'none',
			      color: '#444444',
			      links: '#1985b5'
			    }
			  },
			  features: {
			    scrollbar: false,
			    loop: true,
			    live: true,
			    hashtags: true,
			    timestamp: true,
			    avatars: true,
			    toptweets: true,
			    behavior: 'default'
			  }
			}).render().start();
			</script>
			</section>
		  
			
		
	</aside><!-- .second -->
