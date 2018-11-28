<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT DISTINCT codefunzione, decofunzione, peso
            FROM {$DBMODULI}.BOOK_IncarichiFunzioni
            ORDER BY peso DESC";
    $session->log($sql);
    $rs = $db->Esegui($sql);
    
    #echo "PERSONALE";
    $session->smarty->assign("funzioni", $rs->GetArray());
    $session->smarty->display("funzioni.tpl");
});


#
# Personale per funzione
#
$this->respond('GET', '/[a:codefunzione]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $codefunzione = $request->codefunzione;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT p.*
            FROM {$DBMODULI}.BOOK_VW_Personale as p
            WHERE codefunzione=?
            ORDER BY cognome, nome";
    $session->log($sql);
    $rs = $db->Execute($sql, array($codefunzione));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});


?>