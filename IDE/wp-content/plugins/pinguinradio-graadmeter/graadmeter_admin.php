<?php
/*
 * Admin script voor de graadmeter. Hierin kan de lijst worden bewerkt en online gezet worden.
 * NB: Posities zijn altijd negatief. IJsbergen bevinden zich immers (voornamelijk) onder het wateroppervlak!
*/

date_default_timezone_set('Europe/Amsterdam');

global $wpdb;

$SERVER_REMOTE_ADDR = getClientIP(); 
$SERVER_IS_LOCALHOST = $SERVER_REMOTE_ADDR == "127.0.0.1" || $SERVER_REMOTE_ADDR == "::1";

// Get the list of available MP3 files.
$MP3_FILE_REFS = getMP3FileRefs();

$rows_tips = $wpdb->get_results("SELECT * FROM `ext_graadmeter_tips` ORDER BY `tijdstip` DESC LIMIT 1000");
$rows = $wpdb->get_results(
    "SELECT `g`.*,
            IFNULL(
                (SELECT GROUP_CONCAT(`count`,'@',`ip_adres` ORDER BY `count` DESC,`ip_adres` SEPARATOR '|')
                    FROM (SELECT `ref_top41_voor`,COUNT(1) AS `count`,`ip_adres`
                        FROM `ext_graadmeter_stemmen`
                        GROUP BY `ref_top41_voor`,`ip_adres`
                    ) `v`
                    WHERE `g`.`ref`=`ref_top41_voor`
                    GROUP BY `ref_top41_voor`
                ),
                (SELECT GROUP_CONCAT(`count`,'@',`ip_adres` ORDER BY `count` DESC,`ip_adres` SEPARATOR '|')
                    FROM (SELECT `ref_tip10_voor`,COUNT(1) AS `count`,`ip_adres`
                        FROM `ext_graadmeter_stemmen`
                        GROUP BY `ref_tip10_voor`,`ip_adres`
                    ) `v`
                    WHERE `g`.`ref`=`ref_tip10_voor`
                    GROUP BY `ref_tip10_voor`
                )
            ) AS `stemmen_voor_per_ip`,
            
            IFNULL(
                (SELECT GROUP_CONCAT(`count`,'@',`ip_adres` ORDER BY `count` DESC,`ip_adres` SEPARATOR '|')
                    FROM (SELECT `ref_top41_tegen`,COUNT(1) AS `count`,`ip_adres`
                        FROM `ext_graadmeter_stemmen`
                        GROUP BY `ref_top41_tegen`,`ip_adres`
                    ) `v`
                    WHERE `g`.`ref`=`ref_top41_tegen`
                    GROUP BY `ref_top41_tegen`
                ),
                (SELECT GROUP_CONCAT(`count`,'@',`ip_adres` ORDER BY `count` DESC,`ip_adres` SEPARATOR '|')
                    FROM (SELECT `ref_tip10_tegen`,COUNT(1) AS `count`,`ip_adres`
                        FROM `ext_graadmeter_stemmen`
                        GROUP BY `ref_tip10_tegen`,`ip_adres`
                    ) `v`
                    WHERE `g`.`ref`=`ref_tip10_tegen`
                    GROUP BY `ref_tip10_tegen`
                )
            ) AS `stemmen_tegen_per_ip`,
            
            (SELECT COUNT(1)
                FROM `ext_graadmeter_stemmen`
                WHERE `g`.`ref` IN(`ref_top41_voor`,`ref_tip10_voor`)
            ) AS `stemmen_voor`,
            (SELECT COUNT(1)
                FROM `ext_graadmeter_stemmen`
                WHERE `g`.`ref` IN(`ref_top41_tegen`,`ref_tip10_tegen`)
            ) AS `stemmen_tegen`,
            
            (SELECT SUM(IF(`ref_top41_voor`<>'',1,0)+IF(`ref_tip10_voor`<>'',1,0)+IF(`ref_top41_tegen`<>'',1,0)+IF(`ref_tip10_tegen`<>'',1,0))
                FROM `ext_graadmeter_stemmen`
            ) AS `stemmen_totaal`
        FROM `ext_graadmeter_beheer` `g`
        ORDER BY `g`.`positie` ASC");
$state_results = $wpdb->get_results("SELECT * FROM `ext_graadmeter_beheer_state` WHERE `published` IS NULL");
$isEditable = FALSE;
$isPrepared = FALSE;
if (count($state_results) > 0) {
    $isEditable = TRUE;
    $isPrepared = strtoupper($state_results[0]->prepared) == 'J';
}

$rows_top41 = array();
$rows_exit = array();
$rows_tip10 = array();
$totaal_stemmen_top41_voor = 0;
$totaal_stemmen_top41_tegen = 0;
$totaal_stemmen_tip10_voor = 0;
$totaal_stemmen_tip10_tegen = 0;
$totaal_stemmen = 0;
foreach ($rows as $row) {
    // Stel de tekst voor de tooltips samen, maar alleen als er meerdere keren gestemd is vanaf hetzelfde ip-adres.
    $row->tooltip_stemmen_voor = '';
    if ($row->stemmen_voor_per_ip != NULL && count($row->stemmen_voor_per_ip) > 0) {
        $aantallen_per_ip = explode('|', $row->stemmen_voor_per_ip);
        $aantal_regels_in_tooltip = 0;
        $aantal_stemmen_in_tooltip = 0;
        foreach ($aantallen_per_ip as $aantal_per_ip) {
            if ($aantal_regels_in_tooltip >= 30 && $row->stemmen_voor - $aantal_stemmen_in_tooltip > 1) {
                $row->tooltip_stemmen_voor .= ($row->stemmen_voor - $aantal_stemmen_in_tooltip)
                        . ' van andere ip-adressen';
                break;
            }
            $row->tooltip_stemmen_voor .= str_replace('@', ' van ip-adres ', $aantal_per_ip) . "\n";
            $aantal_stemmen_in_tooltip += intval(str_replace('@.*', '', $aantal_per_ip));
            $aantal_regels_in_tooltip++;
        }
    }
    
    $row->tooltip_stemmen_tegen = '';
    if ($row->stemmen_tegen_per_ip != NULL && count($row->stemmen_tegen_per_ip) > 0) {
        $aantallen_per_ip = explode('|', $row->stemmen_tegen_per_ip);
        $aantal_regels_in_tooltip = 0;
        $aantal_stemmen_in_tooltip = 0;
        foreach ($aantallen_per_ip as $aantal_per_ip) {
            if ($aantal_regels_in_tooltip >= 30 && $row->stemmen_tegen - $aantal_stemmen_in_tooltip > 1) {
                $row->tooltip_stemmen_tegen .= ($row->stemmen_tegen- $aantal_stemmen_in_tooltip)
                        . ' van andere ip-adressen';
                break;
            }
            $row->tooltip_stemmen_tegen .= str_replace('@', ' van ip-adres ', $aantal_per_ip) . "\n";
            $aantal_stemmen_in_tooltip += intval(str_replace('@.*', '', $aantal_per_ip));
            $aantal_regels_in_tooltip++;
        }
    }

    // Voeg stemtotalen toe en verdeel de tracks over de drie lijsten.
    if ($row->lijst == 'top41') {
        $totaal_stemmen_top41_voor += $row->stemmen_voor;
        $totaal_stemmen_top41_tegen += $row->stemmen_tegen;
        $rows_top41[] = $row;
    } else if ($row->lijst == 'exit') {
        $rows_exit[] = $row;
    } else if ($row->lijst == 'tip10') {
        $totaal_stemmen_tip10_voor += $row->stemmen_voor;
        $totaal_stemmen_tip10_tegen += $row->stemmen_tegen;
        $rows_tip10[] = $row;
    }
    
    $totaal_stemmen = $row->stemmen_totaal;
}
$som_stemmen = $totaal_stemmen_top41_voor + $totaal_stemmen_top41_tegen + $totaal_stemmen_tip10_voor + $totaal_stemmen_tip10_tegen;

// Bepaal de week waarin we leven.
$dagInWeek = date("N");
$isWeekend = $dagInWeek > 5;
$weekBegin = time() - 86400 * ($dagInWeek - 1);
if ($isPrepared) {
    $weekBegin += 86400 * 7;
}
$weekEinde = $weekBegin + 86400 * 7;
$jaarBegin = date("Y", $weekBegin);
$jaarEinde = date("Y", $weekEinde);
$maandBegin = date("m", $weekBegin);
$maandEinde = date("m", $weekEinde);
$dagBegin = date("d", $weekBegin);
$datumVan = $dagBegin;
if ($maandBegin != $maandEinde) {
    $datumVan .= "-$maandBegin";
}
if ($jaarBegin != $jaarEinde) {
    $datumVan .= "-$jaarBegin";
}
$datumTot = date("d-m-Y", $weekEinde);

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../wp-content/plugins/pinguinradio-graadmeter/assets/jquery-ui-1.8.11.custom.css" />
    <link rel="stylesheet" type="text/css" href="../wp-content/plugins/pinguinradio-graadmeter/assets/datatables.css" />
    <link rel="stylesheet" type="text/css" href="../wp-content/plugins/pinguinradio-graadmeter/assets/graadmeter_admin.css" />
<?php

if ($SERVER_IS_LOCALHOST) {
    echo '<style>#wpwrap {background-color:#fcf;}</style>';
}

?>
    <script type="text/javascript" language="javascript">
        // Introduce a global variable to enable/disable editing the Graadmeter content.
        var isGraadmeterDataEditable = <?php echo ($isEditable ? 'true' : 'false'); ?>;
    </script>
    <script type="text/javascript" language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
    <script type="text/javascript" language="javascript" src="../wp-content/plugins/pinguinradio-graadmeter/assets/jquery.datatables.min.js"></script>
    <script type="text/javascript" language="javascript" src="../wp-content/plugins/pinguinradio-graadmeter/assets/jquery.jeditable.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="../wp-content/plugins/pinguinradio-graadmeter/assets/jquery.validate.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="../wp-content/plugins/pinguinradio-graadmeter/assets/jquery.dataTables.editable.js" type="text/javascript"></script>
    <script type="text/javascript" language="javascript" src="../wp-content/plugins/pinguinradio-graadmeter/assets/jdataview.js"></script>
    <script type="text/javascript" language="javascript" src="../wp-content/plugins/pinguinradio-graadmeter/assets/graadmeter_admin.js"></script>
    <script type="text/javascript" language="javascript">
<?php if ($SERVER_IS_LOCALHOST) { ?>
function RESET() {
    if (confirm("LET OP:\nJe gaat de gegevens in de BEHEER omgeving RESETTEN.\n\nDoorgaan?")) {
        // Ja? OK, let's go.
        $.post(ajaxurl, {
                action: 'graadmeter_RESET'
            },
            check_database_response_and_reload_page);
    }
};
<?php } ?>
    </script>
</head>
<body>
    <!-- Help texts for popup-balloons. -->
    <div class="balloontip" for="prepareButton">
        <p>Kopieert de Top&nbsp;41 en de Tip&nbsp;10 van LIVE naar BEHEER, wist de Exit-lijst en werkt de 'positie vorige week' bij.</p>
    </div>
    <div class="balloontip" for="publishButton">
        <p>Hoogt het 'aantal weken' van de Top&nbsp;40-tracks op, kopieert dan alle BEHEER-lijsten naar de LIVE omgeving en wist de stemgegevens.</p>
    </div>
    <div class="balloontip" for="unlockButton">
        <p>Maakt de BEHEERgegevens wijzigbaar om een correctie in de huidige LIVE lijsten te kunnen doorvoeren.</p>
    </div>
    <div class="balloontip" for="restoreButton">
        <p>Kopieert de LIVE lijsten terug naar de BEHEERomgeving.</p>
        <p />
        <p>Eventuele wijzigingen in de BEHEERomgeving worden hiermee overschreven.</p>
    </div>
    <div class="balloontip" for="updateButton">
        <p>Kopieert alle BEHEER-lijsten 1&nbsp;op&nbsp;1 naar de LIVE omgeving.</p>
        <p />
        <p>Dit overschrijft de gegevens in de LIVE omgeving, maar houdt de stemgegevens intact.</p>
    </div>

    <a style="position:absolute; top:60px; right:0; text-align:right;" onclick="location.reload();">
        <i>deze pagina is geladen op<br /><?php echo date("d-m-Y H:i:s"); ?></i>
    </a>
<?php

    echo "<h1>Graadmeter BEHEER</h1>";
    $welkeWeek = "";
    if ($isPrepared) {
        $welkeWeek = ($isWeekend ? 'komende' : 'VOLGENDE');
    } else {
        $welkeWeek = ($isWeekend ? 'AFGELOPEN' : 'HUIDIGE');
    }
    echo "<div id='graadmeter_edit_week' style='position:absolute; top:10px; right:0; font-size: 15px;'>"
            . "je bewerkt nu de lijsten van de <b style='font-size:20px;'>$welkeWeek</b> week van $datumVan&nbsp;t/m&nbsp;$datumTot</div>";

    echo "<p>Stemmen Top&nbsp;41: $totaal_stemmen_top41_voor voor en $totaal_stemmen_top41_tegen tegen.";
    echo "<br />Stemmen Tip&nbsp;10: $totaal_stemmen_tip10_voor voor en $totaal_stemmen_tip10_tegen tegen.";
    echo "<br />Totaal aantal stemmen: $som_stemmen.</p>";
    if (!$isPrepared && $som_stemmen != $totaal_stemmen) {
        echo "<h2 class='error'>BUG: er is iets mis met de stemtotalen: "
                . "$totaal_stemmen_top41_voor + $totaal_stemmen_top41_tegen + $totaal_stemmen_tip10_voor + $totaal_stemmen_tip10_tegen"
                . " = <b>$som_stemmen</b> ≠ <b>$totaal_stemmen</b>.</h2>";
    }

    if ($SERVER_IS_LOCALHOST) {
        echo '<button id="resetButton" style="position:absolute; top:35px; right:0; margin-left:10px; color:white; background-color:red;"
                onclick="RESET();">BEHEERgegevens RESETTEN</button>';
    }

?>
    <div class="graadmeter_beheer_button">
        <button id="prepareButton" style="margin:6px;" <?php if ($isEditable) { echo 'disabled="disabled"'; } ?>
                onclick="prepare();">Initialiseren voor de nieuwe week</button>
        <button id="publishButton" style="margin:6px;" <?php if (!$isPrepared) { echo 'disabled="disabled"'; } ?>
                onclick="publish();">Lijsten voor nieuwe week LIVE zetten</button>
        <button id="restoreButton" style="margin:6px; float:right;" <?php if (!$isEditable) { echo 'disabled="disabled"'; } ?>
                onclick="restore();">Wijzigingen annuleren</button>
        <button id="updateButton" style="margin:6px; float:right;" <?php if (!$isEditable || $isPrepared) { echo 'disabled="disabled"'; } ?>
                onclick="updateLive();">Huidige LIVE lijsten bijwerken</button>
        <button id="unlockButton" style="margin:6px; float:right;" <?php if ($isEditable) { echo 'disabled="disabled"'; } ?>
                onclick="unlock();">Beheeromgeving ontgrendelen</button>
    </div>

    <div id="graadmeter_beheer">
        <h2>De Graadmeter Top 41</h2>
        <div id="datatable-top41-wrapper" style="margin:0px; padding:0px;" >
            <table id="top41" lijst="top41" cellpadding="0" cellspacing="0" border="0" class="display" style="font-size: 10px;">
                <thead>
                    <tr>
                        <th>Positie</th>
                        <th>Vorige<br/>week</th>
                        <th>Aantal<br/>weken</th>
                        <th style="text-align:left;">Artiest<br/>naam</th>
                        <th style="text-align:left;">Track<br/>naam</th>
                        <th>Track<br/>MP3</th>
                        <th>(Ex-)<br/>IJsbreker</th>
                        <th title="totaal: <?php echo $totaal_stemmen_top41_voor; ?>">Stemmen<br/>Voor</th>
                        <th title="totaal: <?php echo $totaal_stemmen_top41_tegen; ?>">Stemmen<br/>Tegen</th>
                    </tr>
                </thead>
                <tbody class="connectedSortable">
                    <?php foreach($rows_top41 as $row) {
                        $positie_vw = $row->positie_vw == 0 ? 'nw' : $row->positie_vw * -1;
                        $mp3Present = in_array($row->ref, $MP3_FILE_REFS);
                        $ijsbreker = "N";
                        $ijsbrekerStyle = "";
                        $ijsbrekerTitle = "";
                        if ($row->ijsbreker == 'J') {
                            $ijsbreker = "J";
                            if ($row->positie_vw == 0) {
                                $ijsbrekerStyle = "style='background-color:#faa;'";
                                $ijsbrekerTitle = "title='IJsbreker van " . ($isPrepared ? "komende" : "huidige (afgelopen)") . " week'";
                            } else {
                                $ijsbrekerTitle = "title='Ex-ijsbreker (positie vorige week: $positie_vw)'";
                            }
                        }
                        echo "<tr id='$row->id' $ijsbrekerStyle $ijsbrekerTitle>";
                        echo "<td ref='positie'>" . $row->positie * -1 . "</td>";
                        echo "<td ref='positie_vw'>$positie_vw</td>";
                        echo "<td ref='aantal_wk'>$row->aantal_wk</td>";
                        echo "<td ref='artiest'>$row->artiest</td>";
                        echo "<td ref='track'>$row->track</td>";
                        echo "<td ref='mp3' class='read_only " . ($mp3Present ? "" : "graadmeter_no_mp3")
                                . "' onclick='playPauseMP3(event,\"$row->ref\",\"$mp3Present\")'"
                                . "ondblclick='showMP3UploadDialog(\"$row->ref\");'>MP3</td>";
                        echo "<td ref='ijsbreker'>$ijsbreker</td>";
                        echo "<td ref='stemmen_voor' title='$row->tooltip_stemmen_voor'>$row->stemmen_voor</td>";
                        echo "<td ref='stemmen_tegen' title='$row->tooltip_stemmen_tegen'>$row->stemmen_tegen</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
            <br />
            <button id="btnAddTop41">Nieuw</button>
            <button id="btnExitTop41" disabled="true"
                    onclick="move($('#top41').find('.row_selected').attr('id'), 'exit', 0);">Verplaats naar EXIT-lijst</button>
        </div>

        <br><br><hr />
        <h2>Deze week uit de Graadmeter verdwenen</h2>
        <div id="datatable-exit-wrapper" style="margin:0px; padding:0px;" >
            <table id="exit" lijst="exit" cellpadding="0" cellspacing="0" border="0" class="display" style="font-size: 10px;">
                <thead>
                    <tr>
                        <th>Positie</th>
                        <th>Vorige<br/>week</th>
                        <th>Aantal<br/>weken</th>
                        <th style="text-align:left;">Artiest<br/>naam</th>
                        <th style="text-align:left;">Track<br/>naam</th>
                        <th>Track<br/>MP3</th>
                        <th>Ex-<br/>IJsbreker</th>
                    </tr>
                </thead>
                <tbody class="connectedSortable">
                    <?php foreach($rows_exit as $row) {
                        $mp3Present = in_array($row->ref, $MP3_FILE_REFS);
                        echo "<tr id='$row->id'>";
                        echo "<td ref='positie'>$row->positie</td>";
                        echo "<td ref='positie_vw'>" . $row->positie_vw * -1 . "</td>";
                        echo "<td ref='aantal_wk'>$row->aantal_wk</td>";
                        echo "<td ref='artiest'>$row->artiest</td>";
                        echo "<td ref='track'>$row->track</td>";
                        echo "<td ref='mp3' class='read_only " . ($mp3Present ? "" : "graadmeter_no_mp3")
                                . "' onclick='playPauseMP3(event,\"$row->ref\",\"$mp3Present\")'"
                                . "ondblclick='showMP3UploadDialog(\"$row->ref\");'>MP3</td>";
                        echo "<td ref='ijsbreker'>" . ($row->ijsbreker == 'J' ? 'J' : 'N') . "</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
        </div>

        <br><br><hr />
        <h2>De Tip 10 van Pinguin Radio</h2>
        <div id="datatable-tip10-wrapper" style="margin:0px; padding:0px;" >
            <table id="tip10" lijst="tip10" cellpadding="0" cellspacing="0" border="0" class="display" style="font-size: 10px;">
                <thead>
                    <tr>
                        <th>Tip<br />&nbsp;</th>
                        <th>Aantal<br/>weken</th>
                        <th style="text-align:left;">Artiest<br/>naam</th>
                        <th style="text-align:left;">Track<br/>naam</th>
                        <th>Track<br/>MP3</th>
                        <th title="totaal: <?php echo $totaal_stemmen_tip10_voor; ?>">Stemmen<br/>Voor</th>
                        <th title="totaal: <?php echo $totaal_stemmen_tip10_tegen; ?>">Stemmen<br/>Tegen</th>
                    </tr>
                </thead>
                <tbody class="connectedSortable">
                    <?php foreach($rows_tip10 as $row) {
                        $oudeTipAttr = "";
                        if ($row->aantal_wk > 0) {
                            $oudeTipAttr = "title='Dit is een tip van de afgelopen week.\nJe kunt hem met drag&drop in de Top 41 zetten.' style='color:#c60; font-style:oblique;'";
                        }
                        $mp3Present = in_array($row->ref, $MP3_FILE_REFS);
                        echo "<tr id='$row->id' $oudeTipAttr>";
                        echo "<td ref='positie'>$row->positie</td>";
                        echo "<td ref='aantal_wk'>$row->aantal_wk</td>";
                        echo "<td ref='artiest'>$row->artiest</td>";
                        echo "<td ref='track'>$row->track</td>";
                        echo "<td ref='mp3' class='read_only " . ($mp3Present ? "" : "graadmeter_no_mp3")
                                . "' onclick='playPauseMP3(event,\"$row->ref\",\"$mp3Present\")'"
                                . "ondblclick='showMP3UploadDialog(\"$row->ref\");'>MP3</td>";
                        echo "<td ref='stemmen_voor' title='$row->tooltip_stemmen_voor'>$row->stemmen_voor</td>";
                        echo "<td ref='stemmen_tegen' title='$row->tooltip_stemmen_tegen'>$row->stemmen_tegen</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
            <br />
            <button id="btnAddTip10">Nieuw</button>
            <button id="btnDeleteTip10">Verwijder</button>
            <button id="btnDeleteAllOldTips" <?php if (!$isEditable) { echo 'disabled="disabled"'; } ?>
                    onclick="deleteAllOldTips();">Verwijder alle tips van de afgelopen week</button>
        </div>
    </div>

    <br><br><hr />
    <h2>Tips van luisteraars</h2>
    <div style="margin:0px; padding:0px;" >
        <table id="tips" cellpadding="0" cellspacing="0" border="0" class="display" style="font-size: 10px;">
            <thead>
                <tr>
                    <th style="text-align:right;">#</th>
                    <th style="text-align:left;">IP&nbsp;adres</th>
                    <th style="text-align:left;">Tijdstip</th>
                    <th style="text-align:left;">Tip</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach($rows_tips as $row) {
                    echo "<tr>";
                    echo "<td>" . ++$i . "&nbsp;&nbsp;</td>";
                    echo "<td>$row->ip_adres</td>";
                    echo "<td style='white-space:nowrap;'>$row->tijdstip</td>";
                    echo "<td>$row->tip</td>";
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
    </div>

    <!-- Formulier voor de Add functionaliteit van datatable_editable. -->
    <form id="formAddTop41" title="Track toevoegen aan Top 41">
        <input type="text" name="action" id="action" hidden="true" value="graadmeter_add" />
        <input type="text" name="lijst" id="lijst" hidden="true" value="top41" />
        <input rel="1" type="number" name="positie_vw" hidden="true" value="0" />
        <input rel="2" type="number" name="aantal_wk" hidden="true" value="0" />
        <label for="file">MP3 file</label><br />
        <input type="file" name="mp3File" id="mp3File" onchange="preFillMP3Data(event);" />
        <br /><label for="artiest">Artiest</label><br />
        <input rel="3" type="text" name="artiest" id="artiest" class="required" />
        <br /><label for="track">Track</label><br />
        <input rel="4" type="text" name="track" id="track" class="required" />
        <br /><label for="positie">Positie</label><br />
        <input rel="0" type="number" name="positie" id="positie" /><br />
        <br /><label for="ijsbrekerTop41Toggle">IJsbreker</label>
        <input type="checkbox" id="ijsbrekerTop41Toggle" onchange="$('#formAddTop41 #ijsbreker').val(this.checked ? 'J' : 'N');" />
        <input rel="5" type="text" name="ijsbreker" id="ijsbreker" hidden="true" value="N" />
        <input rel="6" type="number" name="stemmen_voor" hidden="true" value="0" />
        <input rel="7" type="number" name="stemmen_tegen" hidden="true" value="0" />
        <input rel="8" type="text" name="ref" id="ref" hidden="true" value="<?php echo uniqid('', TRUE); ?>" />
    </form>

    <!-- Formulier voor de Add functionaliteit van datatable_editable. -->
    <form id="formAddTip10" title="Track toevoegen aan Tip 10">
        <input type="text" name="action" id="action" hidden="true" value="graadmeter_add" />
        <input type="text" name="lijst" id="lijst" hidden="true" value="tip10" />
        <input rel="1" type="number" name="positie_vw" id="positie_vw" hidden="true" value="0" />
        <label for="file">MP3 file</label><br />
        <input type="file" name="mp3File" id="mp3File" onchange="preFillMP3Data(event);" />
        <br /><label for="artiest">Artiest</label><br />
        <input rel="2" type="text" name="artiest" id="artiest" class="required" />
        <br /><label for="track">Track</label><br />
        <input rel="3" type="text" name="track" id="track" class="required" />
        <br /><label for="positie">Positie</label><br />
        <input rel="0" type="number" name="positie" id="positie" />
        <input rel="4" type="number" name="stemmen_voor" hidden="true" value="0" />
        <input rel="5" type="number" name="stemmen_tegen" hidden="true" value="0" />
        <input rel="6" type="text" name="ref" id="ref" hidden="true" value="<?php echo uniqid('', TRUE); ?>" />
    </form>
	
</body>
</html>