<?php
/*
 * Deze functie verwerkt de stem(men) die een gebruiker uitgebracht.
 * Deze functie verwerkt tevens tip die een gebruiker aanlevert.
 * Dit gebeurt uiteraard allemaal op de productie omgeving.
 */

// Ontsleutel de invoerwaarden naar de bijbehorende refs.
function getRefFromRandomValue($key, $randomizedRefMap) {
    $value = filter_input(INPUT_POST, $key);
    if (!$value || strlen(trim($value)) == 0) {
        return '';
    } else if (isset($randomizedRefMap[$value])) {
        return $randomizedRefMap[$value];
    } else {
        throw new Exception("Unknown: $value");
    }
}


global $wpdb;
$vandaag = date("Ymd");
$ip_adres = getClientIP();
$response = $ip_adres;

$randomizedRefMapJSON = (isset($_SESSION['randomizedRefMap']) ? $_SESSION['randomizedRefMap'] : '');
try {
    $randomizedRefMap = json_decode($randomizedRefMapJSON, TRUE);
    $ref_top41_voor = getRefFromRandomValue('ref_top41_voor', $randomizedRefMap);
    $ref_top41_tegen = getRefFromRandomValue('ref_top41_tegen', $randomizedRefMap);
    $ref_tip10_voor = getRefFromRandomValue('ref_tip10_voor', $randomizedRefMap);
    $ref_tip10_tegen = getRefFromRandomValue('ref_tip10_tegen', $randomizedRefMap);
} catch (Exception $e) {
    // Spambot request?!
    echo $ip_adres . " spambot_vote:$value:$randomizedRefMapJSON";
    die();
}


if (strlen($ref_top41_voor) == 0
        && strlen($ref_top41_tegen) == 0
        && strlen($ref_tip10_voor) == 0
        && strlen($ref_tip10_tegen) == 0) {
    $response .= ' no_vote';
} else {
    // Is er vanaf dit IP-adres vandaag eerder gestemd?
    $oldVotes = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM `ext_graadmeter_stemmen` WHERE `ip_adres`=%s AND DATE_FORMAT(`datum`,%s)=%s",
        $ip_adres,
        '%Y%m%d',
        $vandaag
    ), ARRAY_A);
    
    if ($oldVotes == NULL) {
        // Dit is een nieuwe stem.
        $numRows = $wpdb->query($wpdb->prepare(
            "INSERT INTO `ext_graadmeter_stemmen`
                (`ip_adres`,`datum`,`ref_top41_voor`,`ref_top41_tegen`,`ref_tip10_voor`,`ref_tip10_tegen`)
                VALUES(%s,%s,%s,%s,%s,%s)",
            $ip_adres,
            $vandaag,
            $ref_top41_voor,
            $ref_top41_tegen,
            $ref_tip10_voor,
            $ref_tip10_tegen
        ));
        if ($numRows == 1) {
            $response .= ' added_vote';
        } else {
            $response .= ' error_adding_vote';
        }
    } else {
        // Deze kiezer is op herhaling!
        if ($ref_top41_voor == $oldVotes['ref_top41_voor']
                && $ref_top41_tegen == $oldVotes['ref_top41_tegen']
                && $ref_tip10_voor == $oldVotes['ref_tip10_voor']
                && $ref_tip10_tegen == $oldVotes['ref_tip10_tegen']) {
            $response .= ' same_vote';
        } else {
            $numRows = $wpdb->query($wpdb->prepare(
                "UPDATE `ext_graadmeter_stemmen` SET
                    `ref_top41_voor`=%s,
                    `ref_top41_tegen`=%s,
                    `ref_tip10_voor`=%s,
                    `ref_tip10_tegen`=%s
                    WHERE `ip_adres`=%s AND DATE_FORMAT(`datum`,%s)=%s",
                $ref_top41_voor,
                $ref_top41_tegen,
                $ref_tip10_voor,
                $ref_tip10_tegen,
                $ip_adres,
                '%Y%m%d',
                $vandaag
            ));
            if ($numRows == 1) {
                $response .= ' updated_vote';
            } else {
                $response .= ' error_updating_vote';
            }
        }
    }
}


// Nu de tip nog.
$tip = filter_input(INPUT_POST, 'tip');
if (!$tip || strlen(trim($tip)) == 0) {
    $response .= ' no_tip';
} else {
    $numRows = $wpdb->query($wpdb->prepare(
        "INSERT INTO `ext_graadmeter_tips`
            (`ip_adres`,`tip`)
            VALUES(%s,%s)",
        $ip_adres,
        escapeBackspaces($tip)
    ));
    if ($numRows == 1) {
        $response .= ' added_tip';
    } else {
        $response .= ' error_adding_tip';
    }
}


echo $response;

?>