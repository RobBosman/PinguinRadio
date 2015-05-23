<?php
/*
 * Deze functie kopieert alle gegevens van BEHEER naar LIVE.
 */

global $wpdb;

// Markeer de state.
$result = $wpdb->query(
    "UPDATE `ext_graadmeter_beheer_state` SET
            `published`=CURRENT_TIMESTAMP
        WHERE `published` IS NULL AND `prepared`='N'");
if ($result != 1) {
    echo "BUG: er zijn lijsten live gezet die zijn geïnitialiseerd voor de volgende week!\nDouble-check o.a. 'aantal weken'.";
}

// Alle BEHEERgegevens kopieren naar LIVE.
$wpdb->query("DELETE FROM `ext_graadmeter`");
$wpdb->query(
    "INSERT INTO `ext_graadmeter`
            (`ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,`aantal_wk`)
        SELECT
            `ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,`aantal_wk`
        FROM `ext_graadmeter_beheer`");


// Archiveer alle MP3 files waarvan de refs nu niet meer in de database aanwezig zijn.
$validRefs = array();
$refRows = $wpdb->get_results("SELECT `ref` FROM `ext_graadmeter`");
foreach ($refRows as $refRow) {
    $validRefs[] = $refRow->ref;
}
$mp3FileRefs = getMP3FileRefs();
foreach ($mp3FileRefs as $mp3FileRef) {
    if (!in_array($mp3FileRef, $validRefs)) {
        rename(constant('MP3_DIRECTORY') . "$mp3FileRef.mp3", constant('MP3_ARCHIEF') . "$mp3FileRef.mp3");
    }
}

?>