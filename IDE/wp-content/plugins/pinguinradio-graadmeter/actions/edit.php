<?php
/*
 * Deze functie wijzigt de 'editable' properties van een bestaand record.
 */

global $wpdb;
$data = $_POST["data"];

$data['artiest'] = escapeBackspaces($data['artiest']);
$data['track'] = escapeBackspaces($data['track']);

$wpdb->query($wpdb->prepare(
        "UPDATE `ext_graadmeter_beheer` SET
            `artiest`=%s,
            `track`=%s,
            `ijsbreker`=%s,
            `positie`=%d,
            `positie_vw`=%d,
            `aantal_wk`=%d
            WHERE `id`=%d",
        $data['artiest'],
        $data['track'],
        strtoupper($data['ijsbreker']) == 'J' ? 'J' : 'N',
        $data['positie'],
        strtoupper($data['positie_vw']) == 'NW' ? 0 : $data['positie_vw'],
        $data['aantal_wk'],
        $data['id']
    ));

?>