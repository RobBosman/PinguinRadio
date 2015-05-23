<?php
/**
 * Template Name: Backstage template. Zichtbaar na registratie.
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


get_header(); 

/* Eerst login */
if ( is_user_logged_in() ) : ?>
	<section id="content" class="row backstage" role="main">			
		<?php //get_sidebar('left'); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page-fullwidth' ); ?>
				<?php  //comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
		<?php //get_sidebar('right'); ?>
	</section><!-- #content -->
		
<?php	else :?>

	<section id="content" class="row" role="main">
		<?php get_sidebar('left'); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="sevencol content-bg">
					<h1>Hallo! Je moet eerst even inloggen!</h1>
					<p>Dat doe je onderaan de pagina!</p>
				</div>
			<?php endwhile; // end of the loop. ?>
		<?php get_sidebar('right'); ?>
	</section>
	
<? endif; ?>

<?php get_footer(); ?>