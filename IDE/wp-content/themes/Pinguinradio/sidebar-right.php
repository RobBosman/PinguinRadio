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

	<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
		<aside class="threecol last" role="complementary">
			<a href="/adverteren"><img src="/_assets/img/content/banners/adverteren.jpg" alt="adverteren" style="margin-bottom: 20px"></a>
			<a href="/adverteren/pixelpage"><img src="http://pinguinradio.com/wp-content/uploads/pixelpage-button.jpg" alt="adverteren" style="margin-bottom: 20px"></a>

			<?php dynamic_sidebar( 'sidebar-right' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?>