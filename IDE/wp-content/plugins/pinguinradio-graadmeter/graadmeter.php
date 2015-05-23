<?php
/*
Plugin Name: Pinguinradio Graadmeter
Plugin URI: 
Description: een plugin om de graadmeter te beheren
Version: 1.0
Author: Gijsbert, Rob
Author URI: 
License: nvt
*/

// Let op: deze constante wordt ook gedefinieerd in ./uploadMP3.php.
define('MP3_DIRECTORY', realpath(dirname(__FILE__)
        . str_replace("/", DIRECTORY_SEPARATOR, "/../../../_assets/mp3/graadmeter"))
        . DIRECTORY_SEPARATOR);
define('MP3_ARCHIEF', realpath(constant('MP3_DIRECTORY') . 'archief') . DIRECTORY_SEPARATOR);

function getMP3FileRefs() {
    $mp3FileRefs = array();
    foreach (scandir(constant('MP3_DIRECTORY')) as $filename) {
        $refMatches = NULL;
        preg_match("/^([a-f0-9\.\-]{20,}).mp3$/", strtolower($filename), $refMatches);
        if (count($refMatches) === 2) {
            $mp3FileRefs[] = $refMatches[1];
        }
    }
    return $mp3FileRefs;
}

function graadmeter_menu() {
    include 'graadmeter_admin.php';
}

function graadmeter_admin_actions() {
    add_object_page("Graadmeter", "Graadmeter", 1, "Graadmeter", "graadmeter_menu");
}
add_action('admin_menu', 'graadmeter_admin_actions');

function escapeBackspaces($text) {
    return str_replace("\\\\", "\\", str_replace("\'", "'", str_replace('\"', '"', $text)));
}

function getClientIP() {
    return $_SERVER['REMOTE_ADDR'];
/*
    $ip_address = FALSE;
    if (!$ip_address) {
        $ip_address = getenv('HTTP_CLIENT_IP');
    }
    if (!$ip_address) {
        $ip_address = getenv('HTTP_X_FORWARDED_FOR');
    }
    if (!$ip_address) {
        $ip_address = getenv('HTTP_X_FORWARDED');
    }
    if (!$ip_address) {
        $ip_address = getenv('HTTP_FORWARDED_FOR');
    }
    if (!$ip_address) {
        $ip_address = getenv('HTTP_FORWARDED');
    }
    if (!$ip_address) {
        $ip_address = getenv('REMOTE_ADDR');
    }
    if (!$ip_address) {
        $ip_address = getenv('UNKNOWN');
    }
    return $ip_address;
*/
}

function graadmeter_sorteerLijst($lijst) {
    global $wpdb;

    // Sorteer de lijst waaraan het record is toegevoegd.
    $naarSortedResults = $wpdb->get_results($wpdb->prepare(
        "SELECT `id` FROM `ext_graadmeter_beheer` WHERE `lijst`=%s ORDER BY `positie` ASC",
        $lijst
    ));
    $positie = 1;
    foreach($naarSortedResults AS $sortedData) {
        $wpdb->query($wpdb->prepare(
            "UPDATE `ext_graadmeter_beheer` SET
                `positie`=%d
                WHERE `id`=%d",
            $positie++,
            $sortedData->id
        ));
    }
}

function graadmeter_tip() {
    // TODO - remove tip.php
    // include 'actions/tip.php';
}

function graadmeter_vote() {
    include 'actions/vote.php';
}


// AJAX function for adding a single Graadmeter record.
function graadmeter_add() {
    include 'actions/add.php';
    // Always die on finishing an AJAX call inside WordPress.
    die();
}
// Register the function as an action for AJAX calls.
add_action('wp_ajax_graadmeter_add', 'graadmeter_add');

function graadmeter_delete() {
    include 'actions/delete.php';
    die();
}
add_action('wp_ajax_graadmeter_delete', 'graadmeter_delete');

function graadmeter_deleteAllOldTips() {
    include 'actions/deleteAllOldTips.php';
    die();
}
add_action('wp_ajax_graadmeter_deleteAllOldTips', 'graadmeter_deleteAllOldTips');

function graadmeter_edit() {
    include 'actions/edit.php';
    die();
}
add_action('wp_ajax_graadmeter_edit', 'graadmeter_edit');

function graadmeter_move() {
    include 'actions/move.php';
    die();
}
add_action('wp_ajax_graadmeter_move', 'graadmeter_move');

function graadmeter_prepare() {
    include 'actions/prepare.php';
    die();
}
add_action('wp_ajax_graadmeter_prepare', 'graadmeter_prepare');

function graadmeter_publish() {
    include 'actions/publish.php';
    die();
}
add_action('wp_ajax_graadmeter_publish', 'graadmeter_publish');

function graadmeter_restore() {
    include 'actions/restore.php';
    die();
}

add_action('wp_ajax_graadmeter_restore', 'graadmeter_restore');
function graadmeter_sort() {
    include 'actions/sort.php';
    die();
}
add_action('wp_ajax_graadmeter_sort', 'graadmeter_sort');

function graadmeter_unlock() {
    include 'actions/unlock.php';
    die();
}
add_action('wp_ajax_graadmeter_unlock', 'graadmeter_unlock');

function graadmeter_updateLive() {
    include 'actions/updateLive.php';
    die();
}
add_action('wp_ajax_graadmeter_updateLive', 'graadmeter_updateLive');

function graadmeter_RESET() {
    include 'actions/RESET.php';
    die();
}
add_action('wp_ajax_graadmeter_RESET', 'graadmeter_RESET');

?>