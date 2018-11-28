<?php

#
# TIPI
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    /*
    Aree scientifico disciplinari
    Centri
    Dipartimenti
    Scuole di Ateneo
    IANUA - Scuola superiore dell'Università degli Studi di Genova (ex Istituto di studi superiori dell'Università di Genova (ISSUGE)

    $tipi = array(
        'amministrazione' => "Amministrazione",
        'scuole' => "Scuole",
        'dipartimenti' => "Dipartimenti",
        'biblioteche' => "Biblioteche",
        'centri' => "Centri"
    );
    */
    
    # Tipi
    $sql = "SELECT codice_tipo_struttura, tipo_struttura
            FROM {$DBMODULI}.BOOK_StruttureTipi
            ORDER BY ordine";
    #$session->log($sql);
    $rs = $db->Esegui($sql);
    $tipi = $rs->GetArray();
    
    #print_r($strutture);
    $session->smarty->assign("tipi", $tipi);
    $session->smarty->display("strutture-tipi.tpl");
    exit();
});


#
# STRUTTURE di un certo TIPO
#
$this->respond('GET', '/tipo-[a:classestruttura]/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $classestruttura = $request->classestruttura;
    $session = getSession();
    $db = getDB();
    
    # Strutture
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_Strutture
            WHERE 1=1
            AND codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            AND codeclasse=?";
    #$session->log($sql);
    $rs = $db->Execute($sql, array($classestruttura));
    $strutture = parseStrutture($rs->GetArray());
    
    
    # Personale per ruolo/profilo
    $sql = "SELECT codeugov, coderuolo, decoruolo, codeprofilo, profilo, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE classe_struttura=?
            group by codeugov, coderuolo, decoruolo, codeprofilo, profilo
            order by codeugov, coderuolo, decoruolo, codeprofilo, profilo";
    #$session->log($sql);
    $rs = $db->Execute($sql, array($classestruttura));
    $personale = array();
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codeugov"];
        $personale[$s][] = $row;
    }
    
    #
    # CONTATORI
    #
    $contatori = array();
    
    # Personale per struttura livello 1
    $sql = "SELECT codeugov, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            AND classe_struttura=?
            group by codeugov
            order by codeugov";
    #$session->log($sql);
    $rs = $db->Execute($sql, array($classestruttura));
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codeugov"];
        $contatori["{$s}"] = $row["numero"];
    }
    
    # Personale per servizio
    $sql = "SELECT codice_servizio, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            AND codice_servizio IS NOT NULL
            AND classe_struttura=?
            group by codice_servizio
            order by codice_servizio";
    #$session->log($sql);
    $rs = $db->Execute($sql, array($classestruttura));
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codice_servizio"];
        $contatori["{$s}"] = $row["numero"];
    }
    
    # Personale per settore
    $sql = "SELECT codice_settore, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            AND codice_settore IS NOT NULL
            AND classe_struttura=?
            group by codice_settore
            order by codice_settore";
    #$session->log($sql);
    $rs = $db->Execute($sql, array($classestruttura));
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codice_settore"];
        $contatori["{$s}"] = $row["numero"];
    }
    
    #print_r($strutture);
    $session->smarty->assign("strutture", $strutture);
    $session->smarty->assign("personale", $personale);
    $session->smarty->assign("contatori", $contatori);
    $session->smarty->display("strutture.tpl");
    exit();
});



#
# INDEX
#
$this->respond('GET', '/all', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    # Strutture
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_Strutture
            WHERE 1=1 --(livello_struttura=1 or tipo_struttura='dipartimento')
            AND codeugov<>'TERZI'
            AND codeugov IS NOT NULL";
    #$session->log($sql);
    $rs = $db->Esegui($sql);
    $strutture = parseStrutture($rs->GetArray());
    
    
    # Personale per ruolo/profilo
    $sql = "SELECT codeugov, coderuolo, decoruolo, codeprofilo, profilo, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            group by codeugov, coderuolo, decoruolo, codeprofilo, profilo
            order by codeugov, coderuolo, decoruolo, codeprofilo, profilo";
    #$session->log($sql);
    $rs = $db->Esegui($sql);
    $personale = array();
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codeugov"];
        $personale[$s][] = $row;
    }
    
    #
    # CONTATORI
    #
    $contatori = array();
    
    # Personale per struttura livello 1
    $sql = "SELECT codeugov, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            group by codeugov
            order by codeugov";
    #$session->log($sql);
    $rs = $db->Esegui($sql);
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codeugov"];
        $contatori["{$s}"] = $row["numero"];
    }
    
    # Personale per servizio
    $sql = "SELECT codice_servizio, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            AND codice_servizio IS NOT NULL
            group by codice_servizio
            order by codice_servizio";
    #$session->log($sql);
    $rs = $db->Esegui($sql);
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codice_servizio"];
        $contatori["{$s}"] = $row["numero"];
    }
    
    # Personale per settore
    $sql = "SELECT codice_settore, count(distinct matricola) as numero
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE codeugov<>'TERZI'
            AND codeugov IS NOT NULL
            AND codice_settore IS NOT NULL
            group by codice_settore
            order by codice_settore";
    #$session->log($sql);
    $rs = $db->Esegui($sql);
    while(!$rs->EOF) {
        $row = $rs->FetchRow();
        $s = $row["codice_settore"];
        $contatori["{$s}"] = $row["numero"];
    }
    
    #print_r($strutture);
    $session->smarty->assign("strutture", $strutture);
    $session->smarty->assign("personale", $personale);
    $session->smarty->assign("contatori", $contatori);
    $session->smarty->display("strutture.tpl");
});



#
# STRUTTURA
#
$this->respond('GET', '/struttura/[a:codeugov]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $codeugov = $request->codeugov;
    $session = getSession();
    $db = getDB();
    $session->log("/strutture/struttura/{$codeugov}");
    
    # Dati struttura
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_Strutture
            WHERE ? in (codeugov,codestruttura)";
    $rs = $db->Execute($sql, array($codeugov));
    $struttura = $rs->GetArray();
    
    # Competenze
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_StruttureCompetenze
            WHERE codeugov=?";
    $rs = $db->Execute($sql, array($codeugov));
    $rows = $rs->GetArray();
    $competenze = $rows[0]["competenze"];
    
    $incarichi = array();
    $sql = "SELECT DISTINCT nome, cognome, matricola, codefunzione, decofunzione
            FROM {$DBMODULI}.BOOK_IncarichiFunzioni
            WHERE codestruttura=?";
    $rs = $db->Execute($sql, array($codeugov));
    $rows = $rs->GetArray();
    foreach($rows as $row) {
        $code = $row["codefunzione"];
        $incarichi[$code][] = $row;
    }
    
    # Funzioni da visualizzare in ordine!
    $funzioni_struttura = array(
        'DFUN01', 'NFU016', 'XXXXXX', 'DFUN02', 'NFU171', 'NFU071', # Rettore, Vicario, DG, Prorettori, Delegati
        'DFUN09', 'NFU055', 'NFUN65', 'NFU961', 'NO8000', 'NFUZ80', 'DFUN05', # direttori
        'DFUN17', 'NFU093', 'NFUN24', 'NFU053', 'NFU028', # vice
        'AFDIR0', 'AFCS00', 'NFUN10', # dirigenti, capi servizio-settore
        'NFUN21', # segretari
        'NF0130', 'NF0131', 'NF0132', 'NF0134', 'NF0133', 'NF0135', 'NF0281', 'NF0280',
        'NF0371'
    );
    
    # Recapiti
    $recapiti = array();
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_StruttureRecapiti
            WHERE codestruttura=?";
    $rs = $db->Execute($sql, array($struttura[0]["codestruttura"]));
    $rows = $rs->GetArray();
    foreach($rows as $row) {
        $tipo = $row["codice_tipo_recapito"];
        $recapiti[$tipo][] = $row;
    }
    
    
    // SELECT TOP 1000 [codestruttura]
      // ,[codice_tipo_recapito]
      // ,[tipo_recapito]
      // ,[recapito]
      // ,[indirizzo]
      // ,[cap]
      // ,[comune]
      // ,[localita]
  // FROM [WMModuli].[dbo].[BOOK_StruttureRecapiti]
    
    #echo "PERSONALE";
    $session->smarty->assign("struttura", $struttura[0]);
    $session->smarty->assign("competenze", nl2br($competenze));
    $session->smarty->assign("incarichi", $incarichi);
    $session->smarty->assign("recapiti", $recapiti);
    $session->smarty->assign("funzioni_struttura", $funzioni_struttura);
    $session->smarty->display("struttura.tpl");
});






#
# Persoanle per struttura
#
$this->respond('GET', '/personale/[a:codeugov]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $codeugov = $request->codeugov;
    $session = getSession();
    $db = getDB();
    $session->log("/strutture/{$codeugov}");
    
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE ? in (codeugov,codice_settore,codice_servizio,codice_area)";
    #$session->log($sql);
    #$rs = $db->Execute($sql, array($codeugov, $codeugov, $codeugov, $codeugov));
    $rs = $db->Execute($sql, array($codeugov));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});

#
# Personale per struttura e ruolo / profilo
#
$this->respond('GET', '/personale/[a:codeugov]/[a:coderuolo]/?[a:codeprofilo]?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $codeugov = $request->codeugov;
    $coderuolo = $request->coderuolo;
    $codeprofilo = $request->codeprofilo;
    $session = getSession();
    $db = getDB();
    
    $sql = "SELECT *
            FROM {$DBMODULI}.BOOK_VW_Personale
            WHERE (? in (codeugov,codice_settore,codice_servizio,codice_area))
            AND coderuolo=?
            AND codeprofilo like ?";
    #$session->log($sql);
    $rs = $db->Execute($sql, array($codeugov, $coderuolo, $codeprofilo."%"));
    $personale = parsePersonale($rs->GetArray());
    
    #echo "PERSONALE";
    $session->smarty->assign("personale", $personale);
    $session->smarty->display("personale.tpl");
});


?>