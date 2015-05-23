<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" class="row" role="main">
			<?php get_sidebar('left'); ?>
			<section class="sixcol">

				<?php
				 if ( have_posts() ) { the_post(); rewind_posts(); }
				 if ( in_category(46) ) {
				 
				 	?>
				 	<h1 class="entrytitle">Top 10 van <?php echo get_the_author();?></h1>
				 	<?
				 	//the_meta(); 
				 	?>
				 	
				 	<table class="top10table">
					 	<tr>
					 		<td>1 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_1", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_1", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>2 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_2", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_2", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>3 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_3", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_3", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>4 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_4", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_4", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>5 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_5", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_5", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>6 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_6", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_6", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>7 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_7", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_7", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>8 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_8", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_8", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>9 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_9", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_9", true); ?></td>
					 	</tr>
					 	<tr>
					 		<td>10 </td>
					 		<td> <?php echo get_post_meta($post->ID, "artiest_10", true); ?></td>
					 		<td> <?php echo get_post_meta($post->ID, "track_10", true); ?></td>
					 	</tr>
				 	</table>
				 	<br>
				 	
				 	
				 	<br><br>
				 	
				 	<a href="https://twitter.com/share" class="twitter-share-button" data-text="Ik heb gestemd op de Top 150 Top van de ijsberg. Stem: http://tinyurl.com/pr-stem-150 Zie hier mijn top 10:" data-via="pinguinradio" data-lang="nl" data-size="large" data-related="pinguinradio">Tweeten</a>
				 		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				 	<div id="fb-root"></div>
					<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=345571098793373";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>
					<?php 
						$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					?>
					
					<div class="fb-share-button" data-href="<?php echo $actual_link;?>" data-type="button"></div>
					<br><br>
<?php
				 
				 } else {
				 get_template_part( 'content', get_post_format() );
				 comments_template( '', true );
				 }
				 ?>
           

													
													<h1>Meer in <?php the_category(' '); ?></h1>
													<?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                                        query_posts("showposts=10&paged=$page"); while ( have_posts() ) : the_post() ?>
                                                    
                                                    
                                                    <div class="post_excerpt" id="post-<?php the_ID(); ?>">
                                                    
                                                        <h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                                                    
                                                        	<?php the_excerpt(); ?>
                                                    
                                                    	
                                                    
                                                    </div>
                                                    
                                                    <?php endwhile; ?>
                                                    
                                                    <p><?php //posts_nav_link(); ?></p>		  
									
							
		

			</section>
									<?php get_sidebar('news'); ?>
									
										

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>