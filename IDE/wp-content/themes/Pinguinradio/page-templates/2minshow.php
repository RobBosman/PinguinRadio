<?php
/**
 * Template Name: 2minshow!
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

		<section id="content" class="row" role="main">			
               
			<?php if ( is_user_logged_in() ) : ?>
			    
			    	
                        
                        <iframe src="http://2minshow.pinguinradio.com/" 
        				    style="border:0px #FFFFFF none;" 
        				    name="2 minutenshow" 
        				    scrolling="no" 
        				    frameborder="0" 
        				    marginheight="0px" 
        				    marginwidth="0px" 
        				    height="2500px" 
        				    width="100%"
        				    >
        				</iframe>

			    		<?php
			    		/*
			    		 } else { ?>
    			    		<div style="background-color:#fff;">We zijn heel even de boel aan het onderhouden. Als je wilt uploaden kun je dat morgen weer doen!</div>
			    		<?php				  
			    		} */
                        ?>
			    
				 
				<?php	else :?>
				
				<?php while ( have_posts() ) : the_post(); ?>
				<?php //get_template_part( 'content', 'page-fullwidth' ); ?>
				
                <section id="content" class="row" role="main">			
                    <?php get_sidebar('left'); ?>
                    	
                        <article class="sevencol content-bg" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                            	<h3 class="page-head">De 2 Minuten show!</h3>
                            	<h1 class="entry-title">Airplay voor iedereen!</h1>
                            </header>
                            
                            <div class="entry-content">
                                <p>
                                <b style="font-size:15px; color:#ee0000;">Jiehooee! We zijn even met vakantie en gaan weer door op 31 Augustus 2014!</b>
                                    Het is weer zover. De 2minutenshow is terug. Upload de beste track van je band en wij gaan hem draaien op pinguinradio.com 2 Minuten en als er dan de aansluitende week veel op gestemd wordt door onze luisteraars draaien we de track helemaal.
                                </p>
                                <h2>Kans op optreden in Paradiso</h2>
                                <p>
                                    Er is al twee keer het '30 x 20 minuten festival' geweest in Paradiso met meer dan 1200 man in de zaal rocken op het mooiste pop podium van Nederland. Het gaat vanzelf. up load je track en wij houden bij wie er de meeste stemmen krijgt. De 30 bands met de meeste stemmen staan in Paradiso. Nummer 30 opent in de kelder en nummer 1 sluit af in de grote zaal!
                                </p>
                                <p><b>Zo werkt het:</b></p>
                                <p>
                                    log in de backstage (onderaan de pagina) met je facebook account. Upload je track, wacht tot je uitgezonden wordt en mobiliseer dan je fans... Airplay voor iedereen op Pinguinradio.com
                                </p>
                            </div><!-- .entry-content -->
                            <footer class="entry-meta">
                            	
                            </footer><!-- .entry-meta -->
                        </article><!-- #post -->
                    	
                    <?php get_sidebar('right'); ?>
                </section><!-- #content -->
				
				<?php endwhile; // end of the loop. ?>
				
				<? endif; ?>
				<?php // comments_template( '', true ); ?>
			
		</section>

<?php get_footer(); ?>