<?php
/**
 * Template Name: Paradisoform
 *
 * Description: Net gedraaid template
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="content" class="row" role="main">			
			<?php get_sidebar('left'); ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page-form' ); ?>
					<?php  //comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>
		<?php get_sidebar('right'); ?>
		
			
		</section><!-- #content -->

		

<?php get_footer(); ?>