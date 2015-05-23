<?php
/**
 * Template Name: Engels Default
 *
 * Description: De standaard twee column template voor engelse pages
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
		
		<section id="content" class="row" role="main">			
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page-twocol' ); ?>
					<?php  //comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>
			<?php get_sidebar('right-eng'); ?>
		</section><!-- #content -->

<?php get_footer(); ?>