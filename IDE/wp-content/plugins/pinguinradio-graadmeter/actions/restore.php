<?php
/*
 * Deze functie kopieert alle gegevens van LIVE naar BEHEER.
 */

global $wpdb;

// Alle LIVE gegevens kopieren naar BEHEER.
$wpdb->query("DELETE FROM `ext_graadmeter_beheer`");
$wpdb->query(
    "INSERT INTO `ext_graadmeter_beheer`
            (`ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,`aantal_wk`)
        SELECT
            `ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,`aantal_wk`
        FROM `ext_graadmeter`");

// Reset any publishing-state.
$wpdb->query("DELETE FROM `ext_graadmeter_beheer_state` WHERE `published` IS NULL");

?>