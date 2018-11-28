<?php
require_once "../src/customs.inc.php";
define('ADODB_ASSOC_CASE',0);
require_once "../vendor/autoload.php";
require_once "../src/classes/session.class.php";
require_once "../src/classes/db.class.php";
require_once "../src/classes/meta.class.php";
require_once "../src/classes/user.class.php";

$DBMODULI = "dbo";
#$DBUGOV = "NGINTEGRA.WMModuli.dbo";

#
# SSO login
#
// require_once('/var/simplesamlphp/lib/_autoload.php');
// $as = new \SimpleSAML\Auth\Simple('default-sp');
// $as->requireAuth();
// $attributes = $as->getAttributes();
// $session = getSession();
// $session->log($attributes);



# GET SESSION
function getUser() {
    if (isset($_SESSION['USER'])) {
        $operatore = unserialize($_SESSION['USER']);
    }
    else {
        $operatore = new User();
    }
    return $operatore;
}

# GET SESSION
function getSession() {
    if (isset($_SESSION['SESSION'])) {
        $session = unserialize($_SESSION['SESSION']);
    }
    else {
        $session = new Session();
        $session->log("nuova sessione");
    }
    return $session;
}

# GET DB
function getDB() {
    $db = new DB();
    $db->Connetti() or die("DB KO");
	$db->Init();
    return $db;
}
	
function parsePersonale($arr) {
    $result = array();
    foreach($arr as $item) {
        $matricola = $item["matricola"];
        $locale = @$item["codice_locale"];
        $funzione = @$item["codefunzione"];
        if (!isset($result["{$matricola}"]))
            $result["{$matricola}"] = $item;
        if (!isset($result["{$matricola}"]["locations"]))
            $result["{$matricola}"]["locations"] = array();
        if (strlen($locale))
            $result[$matricola]["locations"][$locale] = $item;
        if (!isset($result["{$matricola}"]["assignments"]))
            $result["{$matricola}"]["assignments"] = array();
        if (strlen($funzione))
            $result[$matricola]["assignments"][$funzione] = $item;
    }
    
    return $result;
}

function parseStrutture($arr) {
    $result = array();
    foreach($arr as $item) {
        $codeugov = $item["codeugov"];
        $tipo_struttura = $item["tipo_struttura"];
        $livello_struttura = $item["livello_struttura"];
        $codice_area = $item["codice_area"];
        $codice_servizio = $item["codice_servizio"];
        $codice_settore = $item["codice_settore"];
        
        if ($livello_struttura == 1) {
            $result["{$codeugov}"] = $item;
        }
        elseif (strlen($codice_settore) > 0) {
            if (strlen($codice_servizio) > 0)
                $result["{$codice_area}"]["servizi"]["{$codice_servizio}"]["settori"]["{$codice_settore}"]["nome"] = $item["settore"];
            else
                $result["{$codice_area}"]["settori"]["{$codice_settore}"]["nome"] = $item["settore"];
        }
        elseif (strlen($codice_servizio) > 0) {
            $result["{$codice_area}"]["servizi"]["{$codice_servizio}"]["nome"] = $item["servizio"];
        }
    }
    
    return $result;
}

################################################################################
# cifra:
################################################################################
function cifra($str) {
	return base64_encode($str);
}

################################################################################
# decifra:
################################################################################
function decifra($str) {
	return base64_decode($str);
}

################################################################################
# SendMail:
################################################################################
function SendMail($target, $subject, $message, $headers=null) {
    error_log("------------------------------------------------------------------------");
    error_log("Mail: ".$target);
    error_log($subject);
    error_log($message);
    error_log("------------------------------------------------------------------------");
}

# FUNZIONE SLUGIFY
function parseSearchInput($text) {
    // replace non letter or digits by ''
    $text = preg_replace('~[^\pL\d]+~u', '', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text);

    // remove duplicate -
    $text = preg_replace('~-+~', '', $text);
    $text = str_replace('-', '', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return '';
    }

    return $text;
}
error_log('Load common;');
?>
