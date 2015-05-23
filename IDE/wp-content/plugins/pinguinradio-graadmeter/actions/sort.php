<?php
/*
 * Deze functie hernummert de posities van alle records zodat ze weer overeenkomen met de datatable op de webpagina.
 */

global $wpdb;
$data = $_POST["data"];

for ($i = 0; $i < count($data); $i++) {
    $wpdb->query($wpdb->prepare(
        "UPDATE `ext_graadmeter_beheer` SET
            `positie`=%d
            WHERE `id`=%d",
        $i + 1,
        $data[$i]
    ));
}

?>