<?php do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php do_action( 'bp_before_profile_field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

				<ul>
					<li>Hallo! Ik ben <?php bp_profile_field_data( 'field=Naam' );?> uit <?php bp_profile_field_data( 'field=Stad' );?>!</li>
					<li>Ik luister naar deze muziek:</li>
					<li><?php bp_profile_field_data( 'field=Muziek' );?></li>
				</ul>
				
				<?php
					/*
					$profile_array = bp_profile_field_data( 'field=Muziek' );
					
					echo '<pre>';
					print_r(explode(', ', $profile_array));
					echo '<pre>';
					*/
				?>
					
			</div>

			<?php do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ); ?>
