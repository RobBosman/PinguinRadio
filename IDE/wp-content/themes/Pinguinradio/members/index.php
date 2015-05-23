<?php

/**
 * BuddyPress - Members Directory
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

get_header( 'buddypress' ); ?>

	<?php do_action( 'bp_before_directory_members_page' ); ?>

	<div id="content" class="row">
			<div class="padder members">
	
			<?php do_action( 'bp_before_directory_members' ); ?>
	
			<form action="" method="post" id="members-directory-form" class="dir-form">
	
				<h3>Alle pinguins in de backstage!</h3>
	
				<?php do_action( 'bp_before_directory_members_content' ); ?>
	
				<div id="members-dir-search" class="dir-search" role="search">
					<div>
						Vul hier een gaaf zoekwoord in om te kijken welke pinguins nog meer je muziek smaak delen, vul bijvoorbeeld 'Jouw favoriete band' in! Leuk!
					</div>
	
					<?php bp_directory_members_search_form(); ?>
	
				</div><!-- #members-dir-search -->
	
				<div class="item-list-tabs" role="navigation">
					<ul>
						<li class="selected" id="members-all"><a href="<?php echo trailingslashit( bp_get_root_domain() . '/' . bp_get_members_root_slug() ); ?>"></a></li>
	
						<?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
	
							<li id="members-personal"><a href="<?php echo bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ?>"><?php printf( __( 'My Friends <span>%s</span>', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>
	
						<?php endif; ?>
	
						<?php //do_action( 'bp_members_directory_member_types' ); ?>
	
					</ul>
				</div><!-- .item-list-tabs -->
	
				<div id="members-dir-list" class="members dir-list">
	
					<?php locate_template( array( 'members/members-loop.php' ), true ); ?>
	
				</div><!-- #members-dir-list -->
	
				<?php do_action( 'bp_directory_members_content' ); ?>
	
				<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>
	
				<?php do_action( 'bp_after_directory_members_content' ); ?>
	
			</form><!-- #members-directory-form -->
	
			<?php do_action( 'bp_after_directory_members' ); ?>
	
			</div><!-- .padder -->
	</div><!-- #content -->
	
	<?php do_action( 'bp_after_directory_members_page' ); ?>

<?php //get_sidebar( 'buddypress' ); ?>
<?php get_footer( 'buddypress' ); ?>
