<?php
/*
 * Deze functie kopieert alle gegevens van BEHEER naar LIVE, hoogt het veld 'aantal weken' van Top41 tracks op
 * en wist de stemmen en de tips van luisteraars.
 */

global $wpdb;

// Markeer de nieuwe state.
$result = $wpdb->query(
    "UPDATE `ext_graadmeter_beheer_state` SET
        `published`=CURRENT_TIMESTAMP
    WHERE `published` IS NULL AND `prepared`='J'");
if ($result != 1) {
    echo "BUG: er zijn lijsten live gezet ZONDER de juiste initialisatie!\nDouble-check o.a. 'aantal weken'.";
}
// Verwijder state-records ouder dan een maand (2592000 seconden).
$wpdb->query($wpdb->prepare(
    "DELETE FROM `ext_graadmeter_beheer_state`
        WHERE DATE_FORMAT(`published`,%s)<%s
            AND `published` IS NOT NULL",
    '%Y%m%d',
    date("Ymd", time() - 2592000)
));

// Stemgegevens wissen.
$wpdb->query("DELETE FROM `ext_graadmeter_stemmen`");
// Tips ouder dan een maand (2592000 seconden) wissen.
$wpdb->query($wpdb->prepare(
    "DELETE FROM `ext_graadmeter_tips`
        WHERE DATE_FORMAT(`tijdstip`,%s)<%s",
    '%Y%m%d',
    date("Ymd", time() - 2592000)
));

// Aantal weken in de Top41 in de BEHEER omgeving ophogen. Zet het aantal weken van nieuwe tracks op 1.
$wpdb->query($wpdb->prepare(
    "UPDATE `ext_graadmeter_beheer` SET
        `aantal_wk`=CASE WHEN `positie_vw`=0 THEN 1 ELSE `aantal_wk`+1 END
        WHERE `lijst`=%s",
    'top41'
));


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