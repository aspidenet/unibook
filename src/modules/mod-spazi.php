<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    #---------------------------------------------------------------
    # EDIFICI
    $sql = "SELECT codice_edificio as code, codice_edificio + ' - ' + edificio as label
            FROM {$DBMODULI}.BOOK_Edifici";
    $rs = $db->Esegui($sql);
    $edifici = array();
    if ($rs)
        $edifici = $rs->GetArray();

    #---------------------------------------------------------------
    # CATEGORIE
    $sql = "SELECT DISTINCT codice_categoria as code, categoria as label
            FROM {$DBMODULI}.BOOK_DDU
            WHERE codice_categoria IN ('AULE', 'LAB', 'BIB', 'SSTU')";
    $rs = $db->Esegui($sql);
    $categorie = array();
    if ($rs)
        $categorie = $rs->GetArray();

    #---------------------------------------------------------------
    # DDU
    $sql = "SELECT codice_ddu as code, ddu + ' (' + categoria + ')' as label
            FROM {$DBMODULI}.BOOK_DDU
            WHERE codice_categoria IN ('AULE', 'LAB', 'BIB', 'SSTUD')";
    $rs = $db->Esegui($sql);
    $ddu = array();
    if ($rs)
        $ddu = $rs->GetArray();

    #---------------------------------------------------------------
    # STRUTTURE
    $sql = "SELECT codeugov as code, codeugov + ' - ' + decostruttura as label
            FROM {$DBMODULI}.BOOK_Strutture
            WHERE codeugov IS NOT NULL
            and tipo_struttura IN ('scuola', 'dipartimento')
            ORDER by codeugov";
    $rs = $db->Esegui($sql);
    $strutture = array();
    if ($rs)
        $strutture = $rs->GetArray();
    
    
    #---------------------------------------------------------------
    #$smarty->assign("poli", $poli);
    $session->smarty->assign("edifici", $edifici);
    $session->smarty->assign("categorie", $categorie);
    $session->smarty->assign("ddu", $ddu);
    $session->smarty->assign("strutture", $strutture);
    $session->smarty->display("spazi-form.tpl");
});


#
# ELENCO SPAZI DA FILTRO
#
$this->respond('POST', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    $passed_params = $request->params();
    
    #---------------------------------------------------------------
    # Filtro EDIFICI
    $edifici = $passed_params["edifici"];
    $filtro_edifici = "";
    if (count($edifici)) {
        $filtro_edifici = " AND codice_edificio IN ('".implode("','", $edifici)."')";
    }
    elseif (strlen(trim($edifici)) > 0)
        $filtro_edifici = " AND codice_edificio='".trim($edifici)."'";
        
    #---------------------------------------------------------------
    # Filtro LOCALE
    $locale = $passed_params["locale"];
    $filtro_locale = "";
    if (strlen(trim($locale)) > 0)
        $filtro_locale = " AND (codice_locale like '%".trim($locale)."%' OR locale like '%".trim($locale)."%') ";
        
    #---------------------------------------------------------------
    # Filtro CATEGORIA
    $categorie = $passed_params["categorie"];
    $filtro_categorie = "";
    if (count($categorie)) {
        $filtro_categorie = " AND codice_categoria IN ('".implode("','", $categorie)."')";
    }
    elseif (strlen(trim($categorie)) > 0)
        $filtro_categorie = " AND codice_categoria='".trim($categorie)."'";
        
    #---------------------------------------------------------------
    # Filtro DDU
    $ddu = $passed_params["ddu"];
    $filtro_ddu = "";
    if (count($ddu)) {
        $filtro_ddu = " AND codice_ddu IN ('".implode("','", $ddu)."')";
    }
    elseif (strlen(trim($ddu)) > 0)
        $filtro_ddu = " AND codice_ddu='".trim($ddu)."'";
        
    #---------------------------------------------------------------
    # Filtro STRUTTURE
    $strutture = $passed_params["strutture"];
    $filtro_strutture = "";
    if (count($strutture)) {
        $filtro_strutture = " AND codice_ugov IN ('".implode("','", $strutture)."')";
    }
    elseif (strlen(trim($categorie)) > 0)
        $filtro_strutture = " AND codice_ugov='".trim($strutture)."'";
 
    #---------------------------------------------------------------
    # SPAZI
    $sql = "SELECT DISTINCT top 1000 codice_edificio, edificio, indirizzo, codice_piano, piano, 
            codice_locale, locale, mq_locale, codice_categoria, categoria, codice_ddu, ddu, 
            capienza, latitudine, longitudine, fotoprinc
            FROM {$DBMODULI}.BOOK_VW_Spazi 
            WHERE 1=1 
            {$filtro_poli}
            {$filtro_edifici}
            {$filtro_locale}
            {$filtro_categorie}
            {$filtro_ddu}
            {$filtro_strutture}";
    $rs = $db->Esegui($sql);
    $spazi = array();
    if ($rs)
        $spazi = $rs->GetArray();

    $session->log($sql);    
    $nlocali = $nmq = $nposti = 0;
    $locali = array();
    foreach($spazi as $spazio) {
        $locale = $spazio["codice_locale"];
        if (!array_key_exists($locale, $locali)) {
            $nlocali++;
            $nmq += $spazio["mq_locale"];
            $nposti += $spazio["capienza"];
        }
    }
    

    #---------------------------------------------------------------
    $session->smarty->assign("nlocali", $nlocali);
    $session->smarty->assign("nmq", round($nmq, 0));
    $session->smarty->assign("nposti", $nposti);
    $session->smarty->assign("spazi", $spazi);
    $session->smarty->assign("APP_BASE_URL", ROOT_DIR.APP_BASE_URL);
    $session->smarty->display("spazi.tpl");
});



?>