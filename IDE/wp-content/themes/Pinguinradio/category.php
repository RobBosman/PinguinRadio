<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="content" class="row" role="main">			
		<?php get_sidebar('left'); ?>
			
			<article class="content-bg sevencol">
				<?php if ( have_posts() ) : ?>
					<header class="archive-header">
						<h1 class="archive-title"><?php printf( single_cat_title( '', false ) ); ?></h1>
		
					<?php if ( category_description() ) : // Show an optional category description ?>
						<div class="archive-meta"><?php echo category_description(); ?></div>
					<?php endif; ?>
					</header><!-- .archive-header -->
		
					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();
		
						/* Include the post format-specific template for the content. If you want to
						 * this in a child theme then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
		
					endwhile;
		
					twentytwelve_content_nav( 'nav-below' );
					?>
		
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</article>

		<?php get_sidebar('right'); ?>
	</section><!-- #content -->

<?php get_footer(); ?>