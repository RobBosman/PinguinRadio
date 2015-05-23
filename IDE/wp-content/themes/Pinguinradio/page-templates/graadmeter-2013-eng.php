<?php
/**
 * Template Name: Graadmeter 2013 Template Engels
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
// Heeft dit ip adres al eerder gestemd?
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

get_header();

?>
<section id="content" class="row" role="main">
    <article class="eightcol content-bg" id="post-61" style="
            background:#070510;
            border-bottom:5px solid #f00;">
        <header id="graadmeter_header" class="entry-header">
            <h3 class="page-head"><?php $parent_title = get_the_title($post->post_parent); echo $parent_title; ?></h3>
            <h1>Top of the iceberg</h1>
            <p>
            	<b>
            	You want the latest update in the wonderful world of indie and alternative pop music? 
            	You don't want to miss really beautiful music, besides all the commercial hits? 
            	Just listen to the Graadmeter or "Top of the Iceberg", the Pinguin Radio's own, exclusive and independent top 41. 
            	Because the hits of tomorrow, are here today. 
            	</b>
            </p>
            <p>
                Every Sunday from 16:00-18:00 (Greenwich Mean Time +1) you can listen to the
                list of all lists, which makes every other list a waste of time. Presented
                by Peter van der Meer.
            </p>
            <p>
                The list is composed by you ! Every day you can select 1 favorite track and
                1 track which should be deleted from the list, according to you. So place
                your votes and listen to the results on Sunday!
            </p>   
        </header>

        <form id="graadmeter_content" onsubmit="vote(this,'<?php echo $_SERVER['REQUEST_URI']; ?>'); return false;">
            <table cellspacing="2">
                <thead>
                    <tr>
                        <th width="50px">This<br />week</th>
                        <th width="40px">Next<br />week</th>
                        <th width="60px">Number&nbsp;of<br />weeks</th>
                        <th width="200px" align="left">Artist<br />name</th>
                        <th width="240px" align="left">Track<br />name</th>
                        <th width="110px">Pinguin Radio<br />(ex)&nbsp;ice-breaker</th>
                        <th colspan='2'>Vote!<br />&nbsp;</th>
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
                        $ijsbreker = ($row->ijsbreker == "J" ? ($row->positie_vw == 0 ? "ICE-BREAKER" : "ex ice-breaker") : "&nbsp;");
                        $ref = $row->ref;
                        $checkedVoor = ($stemData != NULL && $stemData->ref_top41_voor == $ref ? 'checked="checked"' : '');
                        $checkedTegen = ($stemData != NULL && $stemData->ref_top41_tegen == $ref ? 'checked="checked"' : '');
                        echo "<tr>";
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
            <h2>Disappeared from <i>Top of the iceberg </i>this week</h2>
            <table cellspacing="2">
                <thead>
                    <tr>
                        <th width="60px">Last<br />week</th>
                        <th width="60px">Number&nbsp;of<br />weeks</th>
                        <th width="200px" align="left">Artist<br />name</th>
                        <th width="240px" align="left">Track<br />name</th>
                        <th width="104px">Pinguin Radio<br />ex ice-breaker</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows_exit AS $row) {
                        echo "<tr>";
                        echo "<td align='right'>" . ($row->positie_vw == 0 ? 'nw' : $row->positie_vw * -1) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td align='right'>$row->aantal_wk&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        echo "<td>$row->artiest</td>";
                        echo "<td>$row->track</td>";
                        echo "<td align='center'>" . ($row->ijsbreker == "J" ? "ex ice-breaker" : "&nbsp;") . "</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>

            <br />
            <h2>The tips of Pinguin Radio</h2>
            <table cellspacing="2">
                <thead>
                    <tr>
                        <th width="60px">Tip<br />&nbsp;</th>
                        <th width="200px" align="left">Artist<br />name</th>
                        <th width="240px" align="left">Track<br />name</th>
                        <th colspan='2'>Vote!<br />&nbsp;</th>
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
                        echo "<tr>";
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
                Do you have a <b>tip</b> for <i>Top of the iceberg</i>?
                <br/>Please tell us:&nbsp;&nbsp;<input type='text' size='60' maxlength='150' name='tip' id='tip' />
                <br />
                <center>
                    <input type="submit" name="submit" value="Vote now!" />
                    <div class="graadmeter_niet_gestemd"<?php if ($stemData != NULL) echo ' style="display:none;"'; ?>>
                        <i>You can vote once per day.</i>
                    </div>
                    <div class="graadmeter_wel_gestemd"<?php if ($stemData == NULL) echo ' style="display:none;"'; ?>>
                        <i>You've already voted today, but you can still adjust your choice.
                            <br/>Tomorrow you can vote again.</i>
                    </div>
                </center>
            </p>
        </form>
    </article>

<?php get_sidebar('right-twocol'); ?>
</section>
<?php get_footer(); ?>
