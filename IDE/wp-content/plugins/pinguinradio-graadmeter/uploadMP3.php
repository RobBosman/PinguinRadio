<?php
/*
 * Deze functie ontvangt een te uploaden file en slaat die op in /_assets/mp3/graadmeter/.
 * Note that $_FILES["file"]["size"] <= upload_max_filesize
 *           $_FILES["file"]["size"] <= post_max_size
 */

// Let op: deze constante wordt ook gedefinieerd in ./graadmeter.php.
define('MP3_DIRECTORY', realpath(dirname(__FILE__)
        . str_replace("/", DIRECTORY_SEPARATOR, "/../../../_assets/mp3/graadmeter"))
        . DIRECTORY_SEPARATOR);

$data = $_POST;

if (!isset($_FILES["mp3File"])) {
    echo "No uploaded file available.";
} else if ($_FILES["mp3File"]["error"] > 0) {
    echo "Error uploading file: " . $_FILES["mp3File"]["error"];
} else if (!isset($data['ref'])) {
    echo "No reference specified for uploaded file.";
} else {
    $ref = $data['ref'];
    if (move_uploaded_file($_FILES["mp3File"]["tmp_name"], constant('MP3_DIRECTORY') . "$ref.mp3")) {
        echo "OK";
    } else {
        echo "Error moving uploaded file '" . $_FILES["mp3File"]["tmp_name"]
                . "' to '" . constant('MP3_DIRECTORY') . "$ref.mp3'.";
    }
}

?>