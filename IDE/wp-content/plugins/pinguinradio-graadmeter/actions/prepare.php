<?php
/*
 * Deze functie kopieert de Top41 en Tip10 van LIVE naar BEHEER, wist Exit-lijst
 * en werkt `positie_vw` van Top41 tracks bij voor de nieuwe week.
 * Het veld 'aantal_wk' van Tip10 tracks wordt opgehoogd, zodat je oude en nieuwe tips van elkaar kunt onderscheiden.
 */

global $wpdb;

// Beheergegevens wissen.
$wpdb->query("DELETE FROM `ext_graadmeter_beheer`");
// Alle LIVE tracks van de Top 41 kopieren en meteen het veld `positie_vw` bijwerken.
$wpdb->query($wpdb->prepare(
    "INSERT INTO `ext_graadmeter_beheer`
            (`ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,`aantal_wk`)
        SELECT
            `ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,
            `positie` AS `positie_vw`,
            `aantal_wk`
        FROM `ext_graadmeter`
        WHERE `lijst`=%s",
    'top41'
));
// Alle LIVE tracks van de Tip 10 kopieren en meteen het veld `aantal_wk` bijwerken.
$wpdb->query($wpdb->prepare(
    "INSERT INTO `ext_graadmeter_beheer`
            (`ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,`aantal_wk`)
        SELECT
            `ref`,`artiest`,`track`,`ijsbreker`,`lijst`,`positie`,`positie_vw`,
            `aantal_wk`+1 AS `aantal_wk`
        FROM `ext_graadmeter`
        WHERE `lijst`=%s",
    'tip10'
));

// Markeer de state.
$wpdb->query("DELETE FROM `ext_graadmeter_beheer_state` WHERE `published` IS NULL");
$wpdb->query("INSERT INTO `ext_graadmeter_beheer_state` (`prepared`) VALUES('J')");

?>