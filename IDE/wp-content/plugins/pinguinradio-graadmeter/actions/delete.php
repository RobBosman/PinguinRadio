<?php
/*
 * Deze functie verwijdert een record definitief.
 */

global $wpdb;
$data = $_POST;

$id = $data['id'];
$results = $wpdb->get_results($wpdb->prepare(
    "SELECT `lijst`,`positie` FROM `ext_graadmeter_beheer` WHERE `id`=%d",
    $id
));
$lijst = $results[0]->lijst;
$positie = $results[0]->positie;

$wpdb->query($wpdb->prepare(
    "DELETE FROM `ext_graadmeter_beheer` WHERE `id`=%d",
    $id
));

// Laat de posities weer aansluiten.
$wpdb->query($wpdb->prepare(
    "UPDATE `ext_graadmeter_beheer` SET
        `positie`=`positie`-1
        WHERE `lijst`=%s AND `positie`>=%d",
    $lijst,
    $positie
));

?>