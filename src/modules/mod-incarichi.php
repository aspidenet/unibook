<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT DISTINCT i.codefunzione, decofunzione, peso
            FROM {$DBMODULI}.BOOK_IncarichiFunzioni i
            LEFT JOIN {$DBMODULI}.BOOK_Funzioni f ON f.codefunzione=i.codefunzione
            LEFT JOIN {$DBMODULI}.BOOK_FunzioniPesi p ON f.codefunzione=p.codefunzione
            ORDER BY peso DESC";
    $session->log($sql);
    $rs = $db->Esegui($sql);
    
    $session->smarty->assign("incarichi", $rs->GetArray());
    $session->smarty->display("incarichi.tpl");
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