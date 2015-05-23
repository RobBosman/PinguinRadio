<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
		<aside class="twocol clearfix" role="complementary">
		
	<?php
	 /* $footer_thumbs = get_posts('category_name=music&numberposts=1');
	if( $footer_thumbs ) :
	  foreach( $footer_thumbs as $footer_thumb ) {
	  setup_postdata($footer_thumb);
	   ?>
	  
	   <div>
	   	<h3 class="widget-title">Nieuwe Muziek</h3>
	   	<div>
		   	<a href="/music/"><img width="600" height="330" src="<?php get_the_post_thumbnail($footer_thumb->ID) ?>" class="attachment-post-thumbnail wp-post-image" alt="Music"></a>
			</div>
			<div>
				<h3 class="front-left-url"><a style="text-decoration:none;" href="/music/"><?php the_title(); ?></a></h3><p></p>
			</div>
		 <div style="clear:both;"></div>
	   </div>	  
	  <?php
	  }
	endif;
	*/ ?>		
			<?php dynamic_sidebar( 'sidebar-left' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?>