<?php
/**
 * Template Name: Graadmeter Template
 *
 * Description: De graadmeter
 *
 * @package WordPress
 * @subpackage Kleo
 * @author Marcel van Gastel
 * @since Kleo 1.0
 */

global $wpdb;
date_default_timezone_set('Europe/Amsterdam');

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == 'POST') {
    graadmeter_vote();
    // Always die on AJAX calls.
    die();
}

// Make sure that the page will not be cached beyond midnight.
header("Expires: " . date("D, d M Y 23:59:50", time()) . " MET");

// Heeft dit ip adres vandaag al eerder gestemd?
$ip_adres = getClientIP();
$stemData = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM `ext_graadmeter_stemmen` WHERE `ip_adres`=%s AND DATE_FORMAT(`datum`,%s)=%s",
    $ip_adres,
    '%Y%m%d',
    date("Ymd")
), ARRAY_A);

// Toon lijst en mogelijkheid tot stemmen.
$rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM `ext_graadmeter` ORDER BY `positie` ASC"), ARRAY_A);
$rows_top41 = array();
$rows_exit = array();
$rows_tip10 = array();
$randomizedRefMap = array();
foreach ($rows as $row) {
    if ($row['lijst'] == 'exit') {
        $rows_exit[] = $row;
    } else {
        // "Versleutel" alle $ref waarden van $rows_top41 en $rows_tip10, zodat stemmen niet meer door hackers kan
        // worden geautomatiseerd.
$randomValue = $row['ref'];
//        $randomValue = strval(mt_rand());
        $randomizedRefMap[$randomValue] = $row['ref'];
        $row['randomValue'] = $randomValue;
        
        if ($row['lijst'] == 'top41') {
            $rows_top41[] = $row;
        } else if ($row['lijst'] == 'tip10') {
            $rows_tip10[] = $row;
        }
    }
}
// Hou de mapping bij in de session, zodat alles bij het verwerken van het stem-request weer kan worden ontsleuteld,
// zie vote.php.
$_SESSION['randomizedRefMap'] = json_encode($randomizedRefMap);

$MP3_BASE_URL = '/_assets/mp3/graadmeter/';
$id = 0;
$idjs = 0;
$idtip = 0;
$idtipjs = 0;

function addGraadmeterScripts() {
    wp_enqueue_script('Pinguinradio', '/_assets/js/jplayer/jquery.jplayer.js');
    wp_enqueue_script('Pinguinradio javascript', get_theme_root_uri() . '/pinguin-child/assets/js/graadmeter.js');
}
add_action('wp_head', 'addGraadmeterScripts');

get_header(); ?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>


<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

<?php 
    foreach ($rows_top41 AS $row) {
        $player_id_js = $idjs++;
    ?>
    
	$("#jquery_jplayer_<?php echo $player_id_js;?>").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				mp3: "<?php echo $MP3_BASE_URL . $row['ref'] . '.mp3'; ?>"
			});
		},
		play: function() { // To avoid multiple jPlayers playing together.
			$(this).jPlayer("pauseOthers");
		},
		swfPath: "js",
		supplied: "mp3",
		cssSelectorAncestor: "#jp_container_<?php echo $player_id_js;?>",
		wmode: "window",
		globalVolume: true,
		preload: "none",
		smoothPlayBar: true,
		keyEnabled: true
	});

<?php } ?>

<?php 
    foreach ($rows_tip10 AS $row) {
        $player_id_tipjs = $idtipjs++;
    ?>
    
    	$("#jquery_jplayer_tip<?php echo $player_id_tipjs;?>").jPlayer({
    		ready: function () {
    			$(this).jPlayer("setMedia", {
    				mp3: "<?php echo $MP3_BASE_URL . $row['ref'] . '.mp3'; ?>"
    			});
    		},
    		play: function() { // To avoid multiple jPlayers playing together.
    			$(this).jPlayer("pauseOthers");
    		},
    		swfPath: "js",
    		supplied: "mp3",
    		cssSelectorAncestor: "#jp_container_tip<?php echo $player_id_tipjs;?>",
    		wmode: "window",
    		globalVolume: true,
    		preload: "none",
    		smoothPlayBar: true,
    		keyEnabled: true
    	});

<?php } ?>

	
});
//]]></script>



<section id="content" class="row" role="main">
    <article class="content-bg" id="post-61">
        <header id="graadmeter_header" class="entry-header">
            <h3 class="page-head"><?php //$parent_title = get_the_title($post->post_parent); echo $parent_title; ?></h3>
            <h1>DE GRAADMETER – DE INDIE HITLIJST VAN NEDERLAND</h1>
            <p>
                <b>
                Wil je in één klap op de hoogte worden gesteld van wat er leeft in de wondere wereld van de
                onafhankelijke rock en pop? En weten welke prachtige muziek er te beluisteren is, naast alle commerciele
                hitjes? Luister dan naar de Graadmeter, Pinguin's eigen, exclusieve en onafhankelijke hitparade.
                Want de hits van morgen hoor je vandaag al op Pinguinradio!
                </b>
            </p>
            <p>
                Elke zondag van 16:00-19:00 is de Lijst Der Lijsten te horen, de hitlijst die alle andere overbodig
                maakt, gepresenteerd door Peter van der Meer.
            </p>
            <p>
                Dat doen we met hulp van onze luisteraars, jullie dus.
                Wij vragen jullie mee te denken en mee te werken door te stemmen op de platen die je in de lijst wilt
                hebben en te laten weten welk nummers hun beste tijd hebben gehad. Je kunt 1 keer per dag stemmen.
                Stem je meerdere keren per dag, dan worden deze stemmen niet meegenomen in het eindresultaat.
            </p>
            <p>
                Wil je de Graadmeter van afgelopen zondag nog eens naluisteren? Dat kan <a href="http://pinguinradio.com/graadmeter-beluisteren/"><b>HIER</b></a>
            </p>
        </header>

        <form id="graadmeter_content" onsubmit="vote(this,'<?php echo $_SERVER['REQUEST_URI']; ?>'); return false;">
            <table cellspacing="2" style="width:100%;">
                <thead>
                    <tr style="padding-top:10px; background: #000;">
                        <th width="7%">Luister</th>
                        <th width="7%">Deze<br />week</th>
                        <th width="6%">Vorige<br />week</th>
                        <th width="7%">Aantal<br />weken</th>
                        <th width="25%" align="left">Artiest naam</th>
                        <th width="27%" align="left">Track naam</th>
                        <th width="13%">(ex-)ijsbreker</th>
                        <th width="8%" colspan='2'>Stem zelf!<br><span><b style="margin-left: 10%;">+</b> <b style="margin-left: 60%;">-</b></span></th>
                    </tr>
                </thead>
                <tbody>
                
<?php 
                    foreach ($rows_top41 AS $row) {
                        $positie_vw = $row['positie_vw'] == 0 ? 'nw' : $row['positie_vw'] * -1;
                        $ijsbreker = ($row['ijsbreker'] == "J" ? ($row['positie_vw'] == 0 ? "IJSBREKER" : "ex-ijsbreker") : "&nbsp;");
                        $checkedVoor = ($stemData != NULL && $stemData['ref_top41_voor'] == $row['ref'] ? 'checked="checked"' : '');
                        $checkedTegen = ($stemData != NULL && $stemData['ref_top41_tegen'] == $row['ref'] ? 'checked="checked"' : '');
                        $randomValue = $row['randomValue'];
                        $player_id = $id++;
                        
                        echo "<tr class='graad-tr'><td align='center'>";
?>

                                <div id="jquery_jplayer_<?php echo $player_id; ?>" class="jp-jplayer"></div>
                            		<div id="jp_container_<?php echo $player_id; ?>" class="jp-audio">
                            			<div class="jp-type-single">
                            				<div class="jp-gui jp-interface">
                            					<ul class="jp-controls">
                            						<li><a href="javascript:;" class="jp-play" tabindex="1"><img src="http://www.pinguinradio.com/_assets/img/global/layout/player/play-btn.png" width="15px"></a></li>
                            						<li><a href="javascript:;" class="jp-pause" tabindex="1"><img src="http://www.pinguinradio.com/_assets/img/global/layout/player/pause-btn.png" width="15px"></a></li>
                            					</ul>
                            				</div>
                            				<div class="jp-details" style="display: none;">
                            					<ul>
                            						<li><span class="jp-title"></span></li>
                            					</ul>
                            				</div>
                            				<div class="jp-no-solution">
                            					<span>Update Required</span>
                            					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            				</div>
                            			</div>
                            		</div>
                        <?php                        
                        echo "</td><td align='right'>" . $row['positie'] * -1 . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'>$positie_vw&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'>" . $row['aantal_wk'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td>" . $row['artiest'] . "</td>";
                        echo "<td>" . $row['track'] . "</td>";
                        echo "<td style='text-indent:20px;'>$ijsbreker </td>";
                        echo "<td align='center'><input type='radio' name='ref_top41_voor' value='$randomValue' $checkedVoor /></td>";
                        echo "<td align='center'><input type='radio' name='ref_top41_tegen' value='$randomValue' $checkedTegen /></td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <h2>Deze week uit de Graadmeter verdwenen</h2><br>
            <table cellspacing="2" style="width: 100%;">
                <thead>
                    <tr style="padding-top:10px; background: #000;">
                        <th width="6%">Vorige<br />week</th>
                        <th width="7%">&nbsp;</th>
                        <th width="7%">Aantal<br />weken</th>
                        <th width="7%">&nbsp;</th>
                        <th width="25%" align="left">Artiest naam</th>
                        <th width="27%" align="left">Track naam</th>
                        <th width="13%">(ex-)ijsbreker</th>
                        <th width="8%" colspan='2'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows_exit AS $row) {
                        echo "<tr class='graad-tr'>";
                        echo "<td align='right'>" . ($row['positie_vw'] == 0 ? 'nw' : $row['positie_vw'] * -1) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'></td>";
                        echo "<td align='right'>" . $row['aantal_wk'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'></td>";
                        echo "<td>" . $row['artiest'] . "</td>";
                        echo "<td>" . $row['track'] . "</td>";
                        echo "<td align='center'>" . ($row['ijsbreker'] == "J" ? "ex-ijsbreker" : "&nbsp;") . "</td>";
                        echo "<td align='right'></td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <h2>De tips van Pinguin Radio</h2><br>
            <table cellspacing="2" style="width: 100%;">
                <thead>
                      <tr style="padding-top:10px; background: #000;">
                          <th width="6%">Luister</th>
                          <th width="7%">&nbsp;</th>
                          <th width="7%">Tip</th>
                          <th width="7%">&nbsp;</th>
                          <th width="25%" align="left">Artiest naam</th>
                          <th width="27%" align="left">Track naam</th>
                          <th width="13%">&nbsp;</th>
                          <th width="8%" colspan='2'>Stem zelf!<br><span><b style="margin-left: 10%;">+</b> <b style="margin-left: 60%;">-</b></span></th>
                      </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows_tip10 AS $row) {
                        $checkedVoor = ($stemData != NULL && $stemData['ref_tip10_voor'] == $row['ref'] ? 'checked="checked"' : '');
                        $checkedTegen = ($stemData != NULL && $stemData['ref_tip10_tegen'] == $row['ref'] ? 'checked="checked"' : '');
                        $randomValue = $row['randomValue'];
                        $tip_id = $idtip++;
                        
                        echo "<tr class=\"graad-tr\">";
                        
                        ?>
                            	
                            	<td align="center">					  
                                    <div id="jquery_jplayer_tip<?php echo $tip_id?>" class="jp-jplayer"></div>
                                		<div id="jp_container_tip<?php echo $tip_id?>" class="jp-audio">
                                			<div class="jp-type-single">
                                				<div class="jp-gui jp-interface">
                                					<ul class="jp-controls">
                                						<li><a href="javascript:;" class="jp-play" tabindex="1"><img src="http://www.pinguinradio.com/_assets/img/global/layout/player/play-btn.png" width="15px"></a></li>
                                						<li><a href="javascript:;" class="jp-pause" tabindex="1"><img src="http://www.pinguinradio.com/_assets/img/global/layout/player/pause-btn.png" width="15px"></a></li>
                                					</ul>
                                				</div>
                                				<div class="jp-details" style="display: none;">
                                					<ul>
                                						<li><span class="jp-title"></span></li>
                                					</ul>
                                				</div>
                                				<div class="jp-no-solution">
                                					<span>Update Required</span>
                                					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                                				</div>
                                			</div>
                            		</div>
                            	</td>
                        
                        <?php 
                        echo "<td align='right'></td>";
                        echo "<td align='right'>" . $row['positie'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'></td>";
                        echo "<td>" . $row['artiest'] . "</td>";
                        echo "<td>" . $row['track'] . "</td>";
                        echo "<td align='right'></td>";
                        echo "<td align='center'><input type='radio' name='ref_tip10_voor' value='$randomValue' $checkedVoor /></td>";
                        echo "<td align='center'><input type='radio' name='ref_tip10_tegen' value='$randomValue' $checkedTegen /></td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <p style="color:#000 !important;">
                Heb je zelf een <b>tip</b> voor de Graadmeter?
                <br/>Zeg het ons:&nbsp;&nbsp;<input type='text' size='60' maxlength='150' name='tip' id='tip'/>
                <br />
                <center>
                    <input type="submit" name="submit" value="Stem nu!" />
                    <div class="graadmeter_niet_gestemd"<?php if ($stemData != NULL) { echo ' style="display:none;"'; } ?>>
                        <i>Je kunt 1 keer per dag stemmen.</i>
                    </div>
                    <div class="graadmeter_wel_gestemd"<?php if ($stemData == NULL) { echo ' style="display:none;"'; } ?>>
                        <i>Je hebt vandaag al gestemd, maar je kunt je keuze nog aanpassen.
                            <br/>Morgen kun je opnieuw stemmen.</i>
                    </div>
                </center>
            </p>
        </form>
    </article>

    
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>