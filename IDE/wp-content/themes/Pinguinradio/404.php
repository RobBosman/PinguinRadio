<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="content" class="row" role="main">			
		<?php get_sidebar('left'); ?>
			
			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title;?></h3>
					<h1 class="entry-title"><?php _e( 'Oink! Wa doede gij ier?', 'twentytwelve' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Volgens mij ben je de weg een beetje kwijt of hebben wij per ongeluk laten doorlinken naar een niet bestaande pagina. Jammerrr!', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
			
		<?php get_sidebar('right'); ?>
	</section><!-- #content -->

<?php get_footer(); ?>