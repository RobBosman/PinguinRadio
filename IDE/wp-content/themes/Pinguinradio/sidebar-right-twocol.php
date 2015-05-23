<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-right-twocol' ) ) : ?>
		<aside class="fourcol last clearfix" role="complementary">
			<?php dynamic_sidebar( 'sidebar-right-twocol' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?>


	<!-- Added by RoB to display (restore!) the Twitter-aside: -->
        <aside class="fourcol last clearfix" role="complementary">
            <script src="http://widgets.twimg.com/j/2/widget.js"></script> 
            <style type="text/css">
                .twtr-hd {display: none;}
            </style>
            <section id="twitter-2" class="widget widget_twitter">
                <div>
                    <h3 class="widget-title"><span class="twitterwidget twitterwidget-title">Pinguin Radio tweets</span></h3>
                </div>
                <script>
                    new TWTR.Widget({
                        version: 2,
                        type: 'search',
                        search: 'pinguinradio',
                        interval: 7500,
                        title: '',
                        subject: '',
                        width: 240,
                        height: 500,
                        theme: {
                            shell: {
                                color: '#ffffff',
                                background: 'none'
                            },
                            tweets: {
                                background: 'none',
                                color: '#444444',
                                links: '#1985b5'
                            }
                        },
                        features: {
                            scrollbar: false,
                            loop: true,
                            live: true,
                            hashtags: true,
                            timestamp: true,
                            avatars: true,
                            toptweets: true,
                            behavior: 'default'
                        }
                    }).render().start();
                </script>
            </section>
        </aside>