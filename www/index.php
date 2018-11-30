<?php
ob_start();
session_start();
/*error_reporting(E_ALL & ~E_NOTICE);
if (!defined('ADODB_ASSOC_CASE'))
  define('ADODB_ASSOC_CASE', 0);
require_once __DIR__ . '/../vendor/autoload.php';
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
require_once __DIR__ . '/../src/common.inc.php';
require_once __DIR__ . '/../src/classes/medoo.class.php';*/
#set_include_path(get_include_path().PATH_SEPARATOR.'./'.PATH_SEPARATOR.'../'.PATH_SEPARATOR.'../LIB'.PATH_SEPARATOR.'../templates');

require_once("../src/common.inc.php");

$modules = array(
    'personale',
    'edifici',
    'strutture',
    'qualifiche',
    'incarichi',
    'ssd',
    'spazi'
);

try {
    
    $klein = new Klein\Klein();

    // Using range behaviors via if/else
    $klein->onHttpError(function ($code, $router) {
        if ($code >= 400 && $code < 500) {
            $router->response()->body(
                'Oh no, a bad error happened that caused a '. $code
            );
        } elseif ($code >= 500 && $code <= 599) {
            error_log('uhhh, something bad happened');
        }
    });

    $klein->respond('GET', '*', function ($request, $response, $service, $app) {
        GLOBAL $DBMODULI;
        $db = getDB();
        $session = getSession();
        
        // echo cifra(DB_USERNAME);
        // echo cifra(DB_PASSWORD);
        
        
        // $session->log("------------------------------------------------------");
        // $session->log($request->method()." URI: ".$request->uri());
        // $session->log($request->headers());
        // $session->log("------------------------------------------------------");
        // echo "<br>INDEX<br>URI: ".$request->uri()."<br>";
        // echo "PATHNAME: ".$request->pathname()."<br>";
        // echo "METHOD: ".$request->method()."<br>";
        // echo "ROOT_DIR: ".APP_BASE_URL ."<br>";
        // $passed_params = $request->params();
        // $headers = $request->headers();
        // echo "<br>HEADERS:<br>";
        // print_r($headers);
        // echo "<br><br>PARAMS:<br>";
        // print_r($passed_params);
        // echo "-----------------------------------------------------------<br>";
        $session->smarty->assign("APP_BASE_URL", APP_BASE_URL);
        $session->smarty->assign("REQUEST_URI", str_ireplace(APP_BASE_URL, "", $request->pathname()));
        
        $sql = "SELECT TOP 1 *
                FROM {$DBMODULI}.BOOK_Vars 
                ORDER BY last_update DESC";
        #$session->log($sql);
        $rs = $db->Esegui($sql);
        $session->smarty->assign("last_update", $rs->Fields("last_update"));
        $session->smarty->assign("now", time());
        $session->save();
    });

    foreach($modules as $modulo) {
        //Include all routes defined in a file under a given namespace
        $klein->with(APP_BASE_URL."/{$modulo}", "../src/modules/mod-{$modulo}.php");
    }

    # INDEX
    $klein->respond('GET', APP_BASE_URL."/?", function ($request, $response, $service, $app) {
        GLOBAL $DBMODULI;
        $db = getDB();
        $session = getSession();
        $passed_params = $request->params();
        
        if (!isset($passed_params["nome"]) || strlen($passed_params["nome"]) == 0)
            $session->smarty->display("index-search.tpl");
        else {
            $input = $passed_params["nome"];
            
            # CHECK INPUT
            // $service->validate($input)->isSearchName();
            
            // $input = str_replace("'", "''", $input);
            
            // $sql = "SELECT *
                    // FROM {$DBMODULI}.BOOK_VW_Personale 
                    // WHERE (cognome+' '+nome) like ? 
                    // OR (nome+' '+cognome) like ? 
                    // OR matricola like ?
                    // OR email like ? 
                    // OR telefonofisso like ? 
                    // ";
            // $rs = $db->Execute($sql, array("%{$input}%", "%{$input}%", "%{$input}%", "%{$input}%", "%{$input}%"));
            
            // $sql = "SELECT *
                    // FROM {$DBMODULI}.BOOK_FN_FiltraPersonale(?)";
            $sql = "SELECT * FROM {$DBMODULI}.BOOK_VW_Personale 
                    WHERE matricola IN ( 
                        SELECT matricola FROM {$DBMODULI}.BOOK_FiltroRicerca 
                        WHERE filtro like ? 
                    )";
                    
                    
            #$session->log($sql);
            $rs = $db->Execute($sql, array('%'.parseSearchInput($input).'%'));
            $personale = parsePersonale($rs->GetArray());
            
            #echo "PERSONALE";
            $session->smarty->assign("personale", $personale);
            $session->smarty->display("personale.tpl");
        }
        exit();
    });

    # PHP-INFO
    // $klein->respond('GET', APP_BASE_URL."/phpinfo", function ($request, $response, $service, $app) {
        // phpinfo();
        // exit();
    // });
    


    
    
    $klein->dispatch();

}
catch(Exception $ex) {
    echo "ERRORE! ".$ex->getMessage();
    exit();
}
?>