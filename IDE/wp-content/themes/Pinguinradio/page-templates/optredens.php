<?php

/**
 * Template Name: Podium Info Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
		
		<section id="content" class="row" role="main">			
			<?php get_sidebar('left'); ?>
				
		<article class="sevencol content-bg" id="post-61">
			<header class="entry-header">
				<h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title;?></h3>
			</header>
			<section class="content-show">
			<?php the_content(); ?>
			
		
		
		
			<?php
			global $wpdb;
			// this adds the prefix which is set by the user upon instillation of wordpress
			$table_name = "ext_concertagenda";
			// this will get the data from your table
			$concerts_per_page = 300;
			
			$page = mysql_escape_string($_REQUEST['page']);
			$day = mysql_escape_string($_REQUEST['input_day']);
			$month = mysql_escape_string($_REQUEST['input_month']);
			$year = mysql_escape_string($_REQUEST['input_year']);
			
			if($day) {
				$search_date = $year . "-" . $month . "-" . $day;
				$sql_extra = $sql_extra . $sKoppel . " concertagenda_extern_start_date >= '" . $search_date . "'";
				$sKoppel = " AND ";
				$sQuerystring = $sQuerystring . "&input_day=" . $day. "&input_month=" . $month. "&input_year=" . $year;
			}
			
			if($header_file) {
				include($header_file);
			}
			
			//navigatie
			if(! $page || $page == 1) {
				$page = 1;
				$next_page = 2;
				
				$offset = 0;
				$limit = $concerts_per_page;
				
				$navigatie = "<a href=\"?page=".$next_page.$sQuerystring."\">Volgende pagina</a>";
			}
			else {
				$prev_page = $page - 1;	
				$next_page = $page + 1;	
			
				$offset = $concerts_per_page * $prev_page;
				$limit = $concerts_per_page;
				
				$navigatie = "<a href=\"?page=".$prev_page.$sQuerystring."\">Vorige pagina</a> -- <a href=\"?page=".$next_page.$sQuerystring."\">Volgende pagina</a>";
			}
			
				
			$retrieve_data = $wpdb->get_results( "SELECT * FROM $table_name LIMIT ".$offset.", ".$limit."" );

			
			?>
			<div>
			<?php foreach ($retrieve_data as $retrieved_data){ 
			
				if($retrieved_data->concertagenda_extern_picture) {
					$sPic = "<a href=\"".$retrieved_data->concertagenda_extern_link."\" target=\"_blank\"><img class=\"pi-img\" src=\"".$retrieved_data->concertagenda_extern_picture."\" height=\"80\" alt=\"Meer info over ".stripslashes($retrieved_data->concertagenda_extern_name)." ".stripslashes($retrieved_data->concertagenda_extern_podium)." \"></a>";
				}
				else {
					$sPic = "<img class=\"pi-img\" src=\"/_assets/img/content/geenfoto.gif\" height=\"80\">";
				}
			
				if($retrieved_data->concertagenda_extern_podium) {
					$location = stripslashes($retrieved_data->concertagenda_extern_podium)  . ", " . stripslashes($retrieved_data->concertagenda_extern_city);
				}
				else {
					$location = stripslashes($retrieved_data->concertagenda_extern_city);
				}
			
				
				if($retrieved_data->concertagenda_extern_start_date == $retrieved_data->concertagenda_extern_end_date) {
					$datum = strftime("%d %B", strtotime($retrieved_data->concertagenda_extern_start_date));
				}
				else {
					$datum = strftime("%d %B", strtotime($retrieved_data->concertagenda_extern_start_date)) . " - " . strftime("%d %B", strtotime($retrieved_data->concertagenda_extern_end_date));
				}

				
			?>
				<div class="pi-showItem ">
					<a href="<?php echo $retrieved_data->concertagenda_extern_link;?>" class="agendaBtn">Meer info</a>
					<?php echo $sPic; ?>
					<h2><a href="<?php echo $retrieved_data->concertagenda_extern_link;?>" target="_blank"><?php echo $retrieved_data->concertagenda_extern_name;?></a></h2>
					<p class="NewsSummaryPostdate"><?php echo $datum?></p>		
					<h3><?php echo $location; ?></h3>
					<div class="clear"></div>
				</div>
			<?php 
			}
			?>
			
			<?php //echo $navigatie; ?>
			</div>
	
		</article>
				
			<?php get_sidebar('right'); ?>
		</section><!-- #content -->

<?php get_footer(); ?>