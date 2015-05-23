<?php
/**
 * Template Name: Two columns, links content, rechts widgets
 *
 * Description: 
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
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
			<?php get_sidebar('right-twocol'); ?>
		</section>

<?php get_footer(); ?>