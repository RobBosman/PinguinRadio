<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->

	<footer id="colophon" class="row" role="contentinfo">
		<section class="fivecol">
			Copyright <?php echo date("Y"); ?> Pinguin Radio<br> 
		</section>
	</footer>
	
	
</div>

<div class="<?php if ( is_user_logged_in() ) : ?>backstage-logged-in<?php else : ?>backstage-footer<?php endif; ?>">
	<div class="row">
		<section>
						
			<?php
		
			 if ( is_user_logged_in() ) : 
			 		$user_id = get_current_user_id();
					//$user_info = get_userdata($user_id);					
					$user_firstname = get_user_meta($user_id, 'first_name', true);
					$fb_img = get_user_meta($user_id, 'facebook_avatar_full', true);
					?>
					<figure class="backstage-profile-img">
						
						<?php
							if ($fb_img == '')	{
								?>
								<img
								src="/_assets/img/global/layout/backstage/default-profile-pic.gif"
								alt="Joehoe <?php echo $user_firstname; ?>"
								>
								<?php
							} else	{
								?>
								<img
								src="<?php echo $fb_img;?>"
								alt="Joehoe <?php echo $user_firstname; ?>"
								>
								<?php
							}
							
						?>
					</figure>
					<section class="backstage-profile-info">
						<header>
							<hgroup>
								<h2>Ha! <?php echo $user_firstname ?>,</h2>
								<h3>Wat leuk dat je er weer bent!</h3>
							</hgroup>
							<a href="<?php echo wp_logout_url( $_SERVER['REQUEST_URI'] )?>"><?php _e("Logout")?></a>
						</header>	
						<?php
						wp_nav_menu( array( '
						theme_location' => 'backstage', 
						'container' => 'nav',
						'container_id' => 'menu-backstage',
						'menu_class' => 'row',
						) );
						?>					
					</section>
					<?php	
					 else : 
					 	?>
					 		<img src="/_assets/img/global/layout/backstage/backstage-entrance.jpg" style="position:absolute; margin: 0 0 0 0">
					 	<?php
						 echo jfb_output_facebook_btn();
						?>
							<section class="backstage-tekst">
								Luister BACKSTAGE naar de laatste of de eerste uitzendingen van je favo program en maak kans op heerlijke kaarten van je favoriete artiesten.<br> Laat weten welke plaat je wilt horen en nog veeeeel meeer
							</section>
						<?php
				endif; ?>
		</section>	
	</div>
</div>

<?php wp_footer();?>

</body>
</html>