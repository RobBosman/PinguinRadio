<?php
/*
 * Deze functie verplaatst een record van de ene lijst naar de andere, bijvoorbeeld van de 'top41' naar de 'exit' lijst.
 * NB: de 'lijst' property bepaalt in welke lijst een record verschijnt en kan de volgende waarde hebben:
 *   'tip10'
 *   'top41'
 *   'exit'
 */

global $wpdb;
$data = $_POST["data"];

$id = $data['id'];
$naarLijst = $data['lijst'];
$vanLijstResults = $wpdb->get_results($wpdb->prepare(
    "SELECT `lijst` FROM `ext_graadmeter_beheer` WHERE `id`=%d",
    $id
));
$vanLijst = $vanLijstResults[0]->lijst;

// Bepaal de juiste insert-positie.
$insertAtIndex = null;
if (key_exists('insertAtIndex', $data)) {
    $insertAtIndex = $data['insertAtIndex'];
}
if ($insertAtIndex == null || $insertAtIndex < 0) {
    // Append to end.
    $naarLijstResults = $wpdb->get_results($wpdb->prepare(
        "SELECT COUNT(*) AS `length` FROM `ext_graadmeter_beheer` WHERE `lijst`=%s",
        $naarLijst
    ));
    $insertAtIndex = $naarLijstResults[0]->length;
}

// Verplaats het record uit de ene lijst naar de andere lijst.
$wpdb->query($wpdb->prepare(
    "UPDATE `ext_graadmeter_beheer` SET
        `lijst`=%s,
        `positie`=%d
        WHERE `id`=%d",
    $naarLijst,
    $insertAtIndex + 1,
    $id
));

// Sorteer de beide lijsten.
graadmeter_sorteerLijst($vanLijst);
graadmeter_sorteerLijst($naarLijst);

?>