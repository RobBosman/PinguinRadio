<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>
<?php /*
<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'twentytwelve' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		
		<?php $fb_img = get_usermeta($user_id, 'facebook_avatar_full'); ?>
			<ol class="commentlist">
				<?php foreach ($comments as $comment) : ?>
				<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">
					<cite>
						<span class="author"><?php comment_author_link() ?></span><br />
						<span class="time"><?php comment_time() ?> on <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?></a> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?></span>
					</cite>
					<div class="commenttext"><?php comment_text() ?></div>
				</li>
				<?php
				$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
				?>
				<?php endforeach;  ?>
			</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'twentytwelve' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentytwelve' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentytwelve' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php

		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'twentytwelve' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

<?php comment_form(array('must_log_in'=>"<p>Login in onze backstage om te kunnen reageren!<br></p>")); ?>

</div><!-- #comments .comments-area -->
*/?>



