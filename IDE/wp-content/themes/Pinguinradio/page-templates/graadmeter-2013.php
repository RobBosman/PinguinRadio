<?php
/**
 * Template Name: Graadmeter 2013 Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * NB: Posities worden altijd negatief weergegeven. IJsbergen bevinden zich immers (voornamelijk) onder het wateroppervlak!
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// When method == POST, then it's an AJAX call: register votes and/or tips and die.
$ip_adres = $_SERVER['REMOTE_ADDR'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST['ip_adres'] = $ip_adres;
    graadmeter_vote();
    // Always die on AJAX calls.
    die();
}


// Include the CSS stylesheet and Javascript.
function addGraadmeterScripts() {
    wp_enqueue_style('Pinguinradio', get_template_directory_uri() . '/css/graadmeter.css');
    wp_enqueue_script('Pinguinradio', get_template_directory_uri() . '/js/graadmeter.js');
}
add_action('wp_head', 'addGraadmeterScripts');

// Make sure that the page will not be cached beyond midnight.
date_default_timezone_set('Europe/Amsterdam');
header("Expires: " . date("D, d M Y 23:59:50", time()) . " MET");

global $wpdb;
$wpdb->show_errors();
// Heeft dit ip adres vandaag al eerder gestemd?
$stemResults = $wpdb->get_results($wpdb->prepare(
    "SELECT * FROM `ext_graadmeter_stemmen`
        WHERE `ip_adres`=%s
          AND DATE_FORMAT(`datum`,%s)=%s
          AND (`ref_top41_voor`<>'' OR `ref_top41_tegen`<>'' OR `ref_tip10_voor`<>'' OR `ref_tip10_tegen`<>'')",
    $ip_adres,
    '%Y%m%d',
    date("Ymd")
));
$stemData = (count($stemResults) > 0 ? $stemResults[0] : NULL);

// Toon lijst en mogelijkheid tot stemmen.
$rows = $wpdb->get_results("SELECT * FROM `ext_graadmeter` ORDER BY `positie` ASC");
$rows_top41 = array();
$rows_exit = array();
$rows_tip10 = array();
foreach ($rows as $row) {
    if ($row->lijst == 'top41') {
        $rows_top41[] = $row;
    } else if ($row->lijst == 'exit') {
        $rows_exit[] = $row;
    } else if ($row->lijst == 'tip10') {
        $rows_tip10[] = $row;
    }
}

$MP3_BASE_URL = '/_assets/mp3/graadmeter/';

get_header();

?>
<section id="content" class="row" role="main">
    <article class="eightcol content-bg" id="post-61" style="
            background:#070510;
            border-bottom:5px solid #f00;">
        <header id="graadmeter_header" class="entry-header">
            <h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title; ?></h3>
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
                Elke zondag van 16:00-18:00 is de Lijst Der Lijsten te horen, de hitlijst die alle andere overbodig
                maakt, gepresenteerd door Peter van der Meer.
            </p>
            <p>
                Dat doen we met hulp van onze luisteraars, jullie dus.
                Wij vragen jullie mee te denken en mee te werken door te stemmen op de platen die je in de lijst wilt
                hebben en te laten weten welk nummers hun beste tijd hebben gehad. Je kunt 1 keer per dag stemmen.
                Stem je meerdere keren per dag, dan worden deze stemmen niet meegenomen in het eindresultaat.
            </p>
        </header>

        <form id="graadmeter_content" onsubmit="vote(this,'<?php echo $_SERVER['REQUEST_URI']; ?>'); return false;">
            <table cellspacing="2">
                <thead>
                    <tr>
                        <th width="50px">Deze<br />week</th>
                        <th width="40px">Vorige<br />week</th>
                        <th width="60px">Aantal<br />weken</th>
                        <th width="200px" align="left">Artiest<br />naam</th>
                        <th width="240px" align="left">Track<br />naam</th>
                        <th width="104px">Pinguin Radio<br />(ex-)ijsbreker</th>
                        <th colspan='2'>Stem<br />zelf!</th>
                    </tr>
                    <tr>
                        <th colspan='6'></th>
                        <th width='18px'><b>+</b></th>
                        <th width='18px'><b>-</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows_top41 AS $row) {
                        $positie_vw = $row->positie_vw == 0 ? 'nw' : $row->positie_vw * -1;
                        $ijsbreker = ($row->ijsbreker == "J" ? ($row->positie_vw == 0 ? "IJSBREKER" : "ex-ijsbreker") : "&nbsp;");
                        $ref = $row->ref;
                        $checkedVoor = ($stemData != NULL && $stemData->ref_top41_voor == $ref ? 'checked="checked"' : '');
                        $checkedTegen = ($stemData != NULL && $stemData->ref_top41_tegen == $ref ? 'checked="checked"' : '');
$mp3 = "$MP3_BASE_URL$ref.mp3";
                        echo "<tr><!-- $mp3 -->";
                        echo "<td align='right'>" . $row->positie * -1 . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'>$positie_vw&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'>$row->aantal_wk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td>$row->artiest</td>";
                        echo "<td>$row->track</td>";
                        echo "<td style='text-indent:20px;'>$ijsbreker</td>";
                        echo "<td align='center'><input type='radio' name='ref_top41_voor' value='$ref' $checkedVoor /></td>";
                        echo "<td align='center'><input type='radio' name='ref_top41_tegen' value='$ref' $checkedTegen /></td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <h2>Deze week uit de Graadmeter verdwenen</h2>
            <table cellspacing="2">
                <thead>
                    <tr>
                        <th width="60px">Vorige<br />week</th>
                        <th width="60px">Aantal<br />weken</th>
                        <th width="200px" align="left">Artiest<br />naam</th>
                        <th width="240px" align="left">Track<br />naam</th>
                        <th width="104px">Pinguin Radio<br />ex-ijsbreker</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows_exit AS $row) {
$mp3 = "$MP3_BASE_URL$row->ref.mp3";
                        echo "<tr><!-- $mp3 -->";
                        echo "<td align='right'>" . ($row->positie_vw == 0 ? 'nw' : $row->positie_vw * -1) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'>$row->aantal_wk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td>$row->artiest</td>";
                        echo "<td>$row->track</td>";
                        echo "<td align='center'>" . ($row->ijsbreker == "J" ? "ex-ijsbreker" : "&nbsp;") . "</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <h2>De tips van Pinguin Radio</h2>
            <table cellspacing="2">
                <thead>
                    <tr>
                        <th width="60px">Tip<br />&nbsp;</th>
                        <th width="200px" align="left">Artiest<br />naam</th>
                        <th width="240px" align="left">Track<br />naam</th>
                        <th colspan='2'>Stem<br />zelf!</th>
                    </tr>
                    <tr>
                        <th colspan='3'>&nbsp;</th>
                        <th width='18px'><b>+</b></th>
                        <th width='18px'><b>-</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows_tip10 AS $row) {
                        $ref = $row->ref;
                        $checkedVoor = ($stemData != NULL && $stemData->ref_tip10_voor == $ref ? 'checked="checked"' : '');
                        $checkedTegen = ($stemData != NULL && $stemData->ref_tip10_tegen == $ref ? 'checked="checked"' : '');
$mp3 = "$MP3_BASE_URL$ref.mp3";
                        echo "<tr><!-- $mp3 -->";
                        echo "<td align='right'>" . $row->positie . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td>$row->artiest</td>";
                        echo "<td>$row->track</td>";
                        echo "<td align='center'><input type='radio' name='ref_tip10_voor' value='$ref' $checkedVoor /></td>";
                        echo "<td align='center'><input type='radio' name='ref_tip10_tegen' value='$ref' $checkedTegen /></td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <p>
                Heb je zelf een <b>tip</b> voor de Graadmeter?
                <br/>Zeg het ons:&nbsp;&nbsp;<input type='text' size='60' maxlength='150' name='tip' id='tip' />
                <br />
                <center>
                    <input type="submit" name="submit" value="Stem nu!" />
                    <div class="graadmeter_niet_gestemd"<?php if ($stemData != NULL) echo ' style="display:none;"'; ?>>
                        <i>Je kunt 1 keer per dag stemmen.</i>
                    </div>
                    <div class="graadmeter_wel_gestemd"<?php if ($stemData == NULL) echo ' style="display:none;"'; ?>>
                        <i>Je hebt vandaag al gestemd, maar je kunt je keuze nog aanpassen.
                            <br/>Morgen kun je opnieuw stemmen.</i>
                    </div>
                </center>
            </p>
        </form>
    </article>

<?php get_sidebar('right-twocol'); ?>
</section>
<?php get_footer(); ?>
