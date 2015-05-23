<?php
/*
 * Deze functie zet de state op 'UNLOCKED'.
 */

global $wpdb;

// Markeer de state.
$wpdb->query("DELETE FROM `ext_graadmeter_beheer_state` WHERE `published` IS NULL");
$wpdb->query("INSERT INTO `ext_graadmeter_beheer_state` (`prepared`) VALUES('N')");

?>