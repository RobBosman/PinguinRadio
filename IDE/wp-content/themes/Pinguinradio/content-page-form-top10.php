<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article class="sevencol content-bg" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title;?></h3>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>

		<div class="entry-content">
		<img class="alignnone size-full wp-image-3436" alt="foto voor bij artikel" src="http://pinguinradio.com/wp-content/uploads/foto-voor-bij-artikel.jpg" width="637" height="425" />
<a class="popup-form" style="padding:10px 0 10px 10px; font-weight:bold;" href="#" onclick="window.open('http://www.pinguinradio.com/_assets/php/paradisoform/index.php','PinguinRadioParadiso',
		'width=650,height=700,scrollbars=yes,toolbar=no,location=no'); return false; _gaq.push(['_trackEvent', 'Actie', 'PiP', 'Popup'])"><img style="width:96%;" src="/_assets/img/actie/pip-button.jpg"></a>
		
			<?php the_content(); ?>
			herrow
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<a class="popup-form" style="padding:10px; font-weight:bold;" href="#" onclick="window.open('http://www.pinguinradio.com/_assets/php/paradisoform/index.php','PinguinRadioParadiso',
		'width=650,height=700,scrollbars=yes,toolbar=no,location=no'); return false; _gaq.push(['_trackEvent', 'Actie', 'PiP', 'Popup'])"><img style="width:96%;" src="/_assets/img/actie/pip-button.jpg"></a>
		
		
		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
