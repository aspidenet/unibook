<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_Ruoli
            ORDER BY peso desc";
    $session->log($sql);
    $rs = $db->Esegui($sql);
    
    $session->smarty->assign("qualifiche", $rs->GetArray());
    $session->smarty->display("qualifiche.tpl");
});


#
# Personale per qualifica
#
$this->respond('GET', '/[:coderuolo]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $coderuolo = $request->coderuolo;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT TOP 200 *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE coderuolo=?
            ORDER BY cognome, nome";
    $session->log($sql);
    $rs = $db->Execute($sql, array($coderuolo));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});


?>