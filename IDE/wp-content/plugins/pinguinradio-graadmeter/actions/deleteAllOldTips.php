<?php
/*
 * Deze functie verwijdert alle Tip10 records die er de vorige week ook al in stonden.
 */

global $wpdb;

$wpdb->query($wpdb->prepare(
    "DELETE FROM `ext_graadmeter_beheer`
        WHERE `lijst`=%s AND `aantal_wk`>0",
    'tip10'
));

graadmeter_sorteerLijst('tip10');

?>