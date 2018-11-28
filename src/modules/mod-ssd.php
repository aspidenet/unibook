<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_SSD";
    $session->log($sql);
    $rs = $db->Esegui($sql);
    
    #echo "PERSONALE";
    $session->smarty->assign("ssd", $rs->GetArray());
    $session->smarty->display("ssd.tpl");
});


#
# Personale per ruolo
#
$this->respond('GET', '/[:codessd1]/[:codessd2]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $codessd = $request->codessd1."/".$request->codessd2;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT TOP 1000 *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codessd=?";
    $session->log($sql);
    $rs = $db->Execute($sql, array($codessd));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});


?>