<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_Edifici";
    $session->log($sql);
    $rs = $db->Esegui($sql);
    
    #echo "PERSONALE";
    $session->smarty->assign("edifici", $rs->GetArray());
    $session->smarty->display("edifici.tpl");
});


#
# Personale per ruolo
#
$this->respond('GET', '/[a:codeedificio]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $codeedificio = $request->codeedificio;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT TOP 500 *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codice_edificio=?";
    $session->log($sql);
    $rs = $db->Execute($sql, array($codeedificio));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});


?>