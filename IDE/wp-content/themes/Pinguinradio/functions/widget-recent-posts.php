<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*

Plugin Name: Pinguin Posts
Plugin URI: http://www.wppluginsdev.com
Description: Showcase Posts from selected categories in various styles
Version: 1.0
Author: wppluginsdev
Author URI: http://www.wppluginsdev.com

*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*  Copyright 2012  wppluginsdev.com  (email : wppluginsdev@LIVE.COM)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( !defined('WP_CONTENT_DIR') )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' ); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down

if ( !defined('WP_CONTENT_URL') )
	define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); // no trailing slash, full paths only - WP_CONTENT_URL is defined further down

$wpcontenturl=WP_CONTENT_URL;
$wpcontentdir=WP_CONTENT_DIR;
$wpinc=WPINC;

$feacpost_plugin_path = WP_CONTENT_DIR.'/themes/Pinguinradio/functions';
$feacpost_plugin_url = WP_CONTENT_URL.'/themes/Pinguinradio/functions';


	if( file_exists("$feacpost_plugin_path/featured-category-posts-widgets.php") )
	{
		require("$feacpost_plugin_path/featured-category-posts-widgets.php");
	}



add_action('wp_print_styles', 'feacpost_addcss');
function feacpost_addcss()
{
    global $feacpost_plugin_path,$feacpost_plugin_url;
    $myfeacpostStyleUrl='';

    $feacpoststylesheet="feacpost.css";
    if(file_exists(get_template_directory() .'/css/'.$feacpoststylesheet))
    {
		$myfeacpostStyleUrl = get_template_directory_uri() . '/css/' .$feacpoststylesheet;
    }
    elseif(file_exists(get_stylesheet_directory() .'/css/'.$feacpoststylesheet))
    {
		$myfeacpostStyleUrl = get_stylesheet_directory_uri() . '/css/' .$feacpoststylesheet;
    }
    elseif(file_exists($feacpost_plugin_path .'css/'.$feacpoststylesheet))
    {
		$myfeacpostStyleUrl = $feacpost_plugin_url . 'css/' .$feacpoststylesheet;
    }
    if (0 < strlen('myfeacpostStyleUrl'))
    {
		wp_register_style('myfeacpostStyleSheets', $myfeacpostStyleUrl);
		wp_enqueue_style( 'myfeacpostStyleSheets');
    }
}

$feacpost_options = get_option( 'feacpost_plugin_options' );



function feacpost_dcl(){
?>

<div id="fixme">Featured Category Posts Widget by <a href="http://wppluginsdev.com/">wppluginsdev.com</a></div>

<?php

}


// Widget functionality

function feacpost_show_category_posts($widget_id,$before_widget,$after_widget,$before_title,$after_title,$feacpost_numberposts, $feacpost_rpwidgettitle,$feacpost_widget_title_header,$feacpost_widget_classname,$feacpost_widget_container_type,$feacpost_widget_title_header_classname,$feacpost_featured_category,$include_post_thumbnail,$feacpost_post_thumbnail_id,$feacpost_before_widget_code,$feacpost_after_widget_code,$feacpost_before_title_code,$feacpost_after_title_code,$feacpost_post_thumbnail_position,$feacpost_include_post_title,$feacpost_post_title_header,$feacpost_post_title_header_classname,$feacpost_include_post_author,$feacpost_include_post_date,$feacpost_show_post_excerpt,$feacpost_post_excerpt_length,$feacpost_show_continue_reading_link,$feacpost_continue_reading_text,$feacpost_author_date_div_class,$feacpost_posted_by_text,$feacpost_numberposts_sub)
{

	if(!$output = wp_cache_get($widget_id))
	{

		$output = '';

	wp_reset_query();

	$twidth='';
	$theight='';

	if ( isset( $feacpost_featured_category) && '0' != $feacpost_featured_category) {
	$featuredcatid=$feacpost_featured_category;}else {$featuredcatid='';}

	if ( isset( $feacpost_numberposts) && '0' != $feacpost_numberposts) {
	$postsper=$feacpost_numberposts;}else {$postsper='1';}

	if ( isset( $feacpost_numberposts_sub) && '0' != $feacpost_numberposts_sub) {
	$feacpost_numberposts_sub=$feacpost_numberposts_sub;}else {$feacpost_numberposts_sub='5';}

	if ( isset( $feacpost_rpwidgettitle) && '0' != $feacpost_rpwidgettitle) {
	$feacpost_rpwidgettitle=$feacpost_rpwidgettitle;}else {$feacpost_rpwidgettitle='';}

	if ( isset( $feacpost_widget_classname) && '0' != $feacpost_widget_classname) {
	$feacpost_widget_classname=$feacpost_widget_classname;}else {$feacpost_widget_classname='';}

	if ( isset( $feacpost_widget_container_type) && '0' != $feacpost_widget_container_type) {
	$feacpost_widget_container_type=$feacpost_widget_container_type;}else {$feacpost_widget_container_type='';}

	if ( isset( $feacpost_widget_title_header) && '0' != $feacpost_widget_title_header) {
	$feacpost_widget_title_header=$feacpost_widget_title_header;}else {$feacpost_widget_title_header='';}

	if ( isset( $feacpost_widget_title_header_classname) && '0' != $feacpost_widget_title_header_classname) {
	$feacpost_widget_title_header_classname=$feacpost_widget_title_header_classname;}else {$feacpost_widget_title_header_classname='';}

	if ( isset( $include_post_thumbnail) && '0' != $include_post_thumbnail) {
	$include_post_thumbnail=$include_post_thumbnail;}else {$include_post_thumbnail='';}


	if ( isset( $feacpost_post_thumbnail_id) && '0' != $feacpost_post_thumbnail_id ) {
	$feacpost_post_thumbnail_id=$feacpost_post_thumbnail_id;}else {$feacpost_post_thumbnail_id='150';}


	if ( isset( $feacpost_post_thumbnail_position) &&  !empty($feacpost_post_thumbnail_position) ) {
	$feacpost_post_thumbnail_position=$feacpost_post_thumbnail_position;}else {$feacpost_post_thumbnail_position='Left';}

	if ( isset( $feacpost_before_widget_code) && !empty($feacpost_before_widget_code) ) {
	$feacpost_before_widget_code=$feacpost_before_widget_code;}else {$feacpost_before_widget_code=$before_widget;}

	if ( isset( $feacpost_after_widget_code) && !empty($feacpost_after_widget_code) ) {
	$feacpost_after_widget_code=$feacpost_after_widget_code;}else {$feacpost_after_widget_code=$after_widget;}

	if ( isset( $feacpost_before_title_code) && !empty($feacpost_before_title_code) ){
	$feacpost_before_title_code=$feacpost_before_title_code;}else {$feacpost_before_title_code=$before_title;}

	if ( isset( $feacpost_after_title_code) && !empty($feacpost_after_title_code) ) {
	$feacpost_after_title_code=$feacpost_after_title_code;}else {$feacpost_after_title_code=$after_title;}

	if ( isset( $feacpost_post_excerpt_length) && !empty($feacpost_post_excerpt_length) ) {
	$feacpost_post_excerpt_length=$feacpost_post_excerpt_length;}else {$feacpost_post_excerpt_length="500";}


	if ( isset( $feacpost_posted_by_text) && !empty($feacpost_posted_by_text) ) {
	$feacpost_posted_by_text=$feacpost_posted_by_text;}else {$feacpost_posted_by_text="Written by";}

	if ( isset( $feacpost_posted_on_text) && !empty($feacpost_posted_on_text) ) {
	$feacpost_posted_on_text=$feacpost_posted_on_text;}else {$feacpost_posted_on_text="on";}

	if ( isset( $feacpost_continue_reading_text) && !empty($feacpost_continue_reading_text) ) {
	$feacpost_continue_reading_text=$feacpost_continue_reading_text;}else {$feacpost_continue_reading_text="Continue Reading";}




	if(isset($featuredcatid) && !empty($featuredcatid))
	{
		$featuredcatname=get_cat_name($featuredcatid);

		query_posts('cat='.$featuredcatid.'&posts_per_page='.$postsper);

					$output.=$feacpost_before_widget_code;

					if(isset($feacpost_widget_container_type) && !empty($feacpost_widget_container_type)){
					$output.= '<'.$feacpost_widget_container_type;
					if(isset($feacpost_widget_classname) && !empty($feacpost_widget_classname)){ $output.= ' class="'.$feacpost_widget_classname.'"';}
					$output.= '>';
					}

						if(isset($feacpost_rpwidgettitle) && !empty($feacpost_rpwidgettitle))
						{


							if(isset($feacpost_widget_title_header) && !empty($feacpost_widget_title_header))
							{
								$output.= '<';

								$output.= $feacpost_widget_title_header;

							if(isset($feacpost_widget_title_header_classname) && !empty($feacpost_widget_title_header_classname)){ $output.= ' class="'. $feacpost_widget_title_header_classname .'"'; }
							$output.= '>';
							}else {$output.= $feacpost_before_title_code;}

							$output.= $feacpost_rpwidgettitle;

							if(isset($feacpost_widget_title_header) && !empty($feacpost_widget_title_header))
							{
								$output.= '</'. $feacpost_widget_title_header .'>';
							}else {	$output.= $feacpost_after_title_code;}
						}

			while ( have_posts() ) : the_post();

			$fpostids[]=get_the_ID();


			if(isset($include_post_thumbnail) && ($include_post_thumbnail == "Yes") && isset($feacpost_post_thumbnail_id) && (!empty($feacpost_post_thumbnail_id)))
			{
				if ( (function_exists('has_post_thumbnail')) && (has_post_thumbnail(get_the_ID())) )
				{


					if($feacpost_post_thumbnail_position == "Top"){
					$output.='<div>';}
					elseif($feacpost_post_thumbnail_position == "Left"){
					$output.='<div>';
					} elseif($feacpost_post_thumbnail_position == "Right"){
					$output.='<div>';
					} else { $output.='<div>'; }

					$output.='<a href="'.get_permalink().'">';

					$thethumbs = feacpost_get_additional_image_sizes();
							foreach((array)$thethumbs as $name => $size) { if($name == $feacpost_post_thumbnail_id){$twidth=$size['width'];$theight=$size['height'];}}

							$output.=get_the_post_thumbnail(get_the_id(),$feacpost_post_thumbnail_id,array($twidth,$theight));


							$output.='</a>
							</div>';

				}
			 }

			$output.='<div>';


			if(isset($feacpost_include_post_title) && ($feacpost_include_post_title == "Yes"))
			{
				if(isset($feacpost_post_title_header) && !empty($feacpost_post_title_header))
				{$output.= '<'.$feacpost_post_title_header.'>';}
				else { $output.= '<h3 class="front-left-url">';}

				$output.='<a style="text-decoration:none;" href="'.get_permalink().'">'.get_the_title().'</a>';

				if(isset($feacpost_post_title_header) && !empty($feacpost_post_title_header))
				{$output.= '</'.$feacpost_post_title_header.'>';}
				else { $output.= '</h3>';}
			}

			if( (isset($feacpost_include_post_author) && ($feacpost_include_post_author == "Yes")) || (isset($feacpost_include_post_date) && ($feacpost_include_post_date == "Yes")) )
			{
				$output.='<div';

				if(isset($feacpost_author_date_div_class) && !empty($feacpost_author_date_div_class)){$output.= ' class="'.$feacpost_author_date_div_class.'"';} else { $output.= ' style="padding:5px 0;"';}

				$output.='>';


				if(isset($feacpost_include_post_author) && ($feacpost_include_post_author == "Yes"))
				{		$output.= '<span>'.$feacpost_posted_by_text.' '.get_the_author().'</span>';
				}

				if(isset($feacpost_include_post_date) && ($feacpost_include_post_date == "Yes"))
				{		$output.= '<span style="text-align:right;">'.$feacpost_posted_on_text.' '.get_the_date().'</span>';
				}

				$output.='</div>';

			}

			$output.='<p>';

			if(isset($feacpost_show_post_excerpt) && ($feacpost_show_post_excerpt == "Yes"))
			{

				$rcsample = get_the_content();

				$rcstthec = strip_tags($rcsample);
				$rcsspthec = str_replace(' ',' ',$rcstthec );
				$rcsspthec = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $rcsspthec );
				if(strlen($rcsspthec) > $feacpost_post_excerpt_length){$newrcs=feacpost_LimitText(trim($rcsspthec),10,$feacpost_post_excerpt_length,""); $output.= "$newrcs";}
					 else { $newrcs=$rcsspthec;$output.= "$newrcs";}


 				if(isset($feacpost_show_continue_reading_link) && ($feacpost_show_continue_reading_link == "Yes")){
 				$output.=' <a href="'.get_permalink().'" rel="bookmark">';
 				$output.=' '.$feacpost_continue_reading_text;
 				$output.='&rarr;</a>';
 				}
 			}

 				$output.='</p>
 				</div>
 				<div style="clear:both;"></div>';
	endwhile;


		if( isset($feacpost_numberposts_sub) && !empty($feacpost_numberposts_sub) && ($feacpost_numberposts_sub > 0))
		{
			wp_reset_query();
			$numsubs=($feacpost_numberposts_sub + $postsper);

			query_posts('cat='.$featuredcatid.'&posts_per_page='.$numsubs);

			$output.='<ul>';
			while ( have_posts() ) : the_post(); if(!(in_array(get_the_ID(),$fpostids))):
			$output.='<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
			endif; endwhile;
			$output.='</ul>';
			wp_reset_query();
		}

		if(isset($feacpost_widget_container_type) && !empty($feacpost_widget_container_type))
		{
			$output.= '</'.$feacpost_widget_container_type .'>';
		}

		$output.= $feacpost_after_widget_code;

	wp_cache_set($widget_id, $output, '', 18);

	wp_reset_query();
}}

echo $output;

}







?>