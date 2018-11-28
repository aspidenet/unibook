<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT top 500 *
            FROM {$DBMODULI}.BOOK_VW_Personale";
    $session->log($sql);
    $rs = $db->Esegui($sql);
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});


#
# Persona
#
$this->respond('GET', '/[a:matricola]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI, $DBCONSOLIDAMENTO;
    $matricola = substr('000000'.$request->matricola, -6);
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE matricola=?";
    $rs = $db->Execute($sql, array($matricola));
    if ($rs != false) {
        $persone = parsePersonale($rs->GetArray());
        $persona = $persone["{$matricola}"];
    }
    
    #####################################################################################
    # INFO DA CSA - FUNZIONI ATTIVE
    $funzioni = array();
    $sql = "SELECT 
                matricola
              , cognome
              , nome
              , i.codefunzione
              , decofunzione
              , i.codestruttura
              , decostruttura
              , inizioincarico
              , termineincarico
              , peso
              FROM {$DBMODULI}.BOOK_IncarichiFunzioni i
              LEFT JOIN {$DBMODULI}.BOOK_Funzioni f ON f.codefunzione=i.codefunzione
              LEFT JOIN {$DBMODULI}.BOOK_FunzioniPesi p ON f.codefunzione=p.codefunzione
              LEFT JOIN {$DBMODULI}.BOOK_Strutture s ON i.codestruttura=s.codestruttura
            WHERE matricola=?
            order by peso desc, DecoFunzione";
    $rs = $db->Execute($sql, array("{$matricola}"));
    if ($rs != false && $rs->RecordCount())
        $funzioni = $rs->GetArray();
    $session->log($funzioni);
    
    #####################################################################################
    # DOCENZE dal MANIFESTO
    $docenze = array();
    $anno_oggi = date('Y');
    $mese_oggi = date('m');
    if ($mese_oggi < 4)
        $anac = ($anno_oggi-2).",".($anno_oggi-1);
    if ($mese_oggi >= 4 && $mese_oggi <= 8)
        $anac = ($anno_oggi-1);
    else
        $anac = ($anno_oggi-1).",".($anno_oggi);
    $matricola_docente = intval($matricola);
    $sql = "select distinct anac, codcla, nome_cla, classe, codice_ins, nome_ins 
            from {$DBMODULI}.TB_Manifesto_Docenze 
            where matricola_docente={$matricola_docente} and anac IN ({$anac}) 
            ORDER BY anac desc, codcla";
    $rs = $db->Esegui($sql);
    if ($rs != false)
        $docenze = $rs->GetArray();
    
    #####################################################################################
    # COLLEGHI in stanza
    $colleghi = array();
    foreach($persona["locations"] as $location) {
        $locale = $location["codice_locale"];
        if (strlen(trim($locale)) == 0)
            continue;
        
        $sql = "SELECT l.matricola, codice_locale, p.cognome, p.nome
                FROM {$DBMODULI}.BOOK_Localizzazione l
                join {$DBMODULI}.BOOK_Personale p ON p.matricola=l.matricola
                where codice_locale=? and l.matricola<>?";
        $rs = $db->Execute($sql, array($locale, "{$matricola}"));
        if ($rs != false)
            $colleghi[$locale] = $rs->GetArray();
        
    }
   
    
    #####################################################################################
    $session->smarty->assign("persona", $persona);
    $session->smarty->assign("funzioni", $funzioni);
    $session->smarty->assign("docenze", $docenze);
    $session->smarty->assign("colleghi", $colleghi);
    $session->smarty->display("persona.tpl");
});



#
# Personale per qualifica
#
$this->respond('GET', '/profilo/[a:code]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $code = $request->code;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT TOP 200 *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeprofilo=?
            ORDER BY cognome, nome";
    $session->log($sql);
    $rs = $db->Execute($sql, array($code));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});

?>