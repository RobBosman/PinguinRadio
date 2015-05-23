<?php
/*
 * Deze functie creëert een nieuw record en voegt dat toe aan de lijst.
 */

global $wpdb;
$data = $_POST;

$data['artiest'] = escapeBackspaces($data['artiest']);
$data['track'] = escapeBackspaces($data['track']);

// Maak plaats op de te inserten positie.
$wpdb->query($wpdb->prepare(
    "UPDATE `ext_graadmeter_beheer` SET
        `positie`=`positie`+1
        WHERE `lijst`=%s AND `positie`>=%d",
    $data['lijst'],
    $data['positie']
));

$success = $wpdb->query($wpdb->prepare(
    "INSERT INTO `ext_graadmeter_beheer`
        (`ref`,`artiest`,`track`,`lijst`,`ijsbreker`,`positie`)
        VALUES(%s,%s,%s,%s,%s,%d)",
    $data['ref'],
    $data['artiest'],
    $data['track'],
    $data['lijst'],
    strtoupper($data['ijsbreker']) == 'J' ? 'J' : 'N',
    $data['positie']
));
if ($success) {
    echo $wpdb->insert_id;
}

?>