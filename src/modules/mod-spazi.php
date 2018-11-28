<?php


#
# INDEX
#
$this->respond('GET', '/?', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    
    #---------------------------------------------------------------
    # POLI
    // $sql = "SELECT codice_polo as code, polo as label
            // FROM {$DBMODULI}.dbo.BOOK_Poli";
    // $rs = $db->Esegui($sql);
    // $poli = array();
    // if ($rs)
        // $poli = $rs->GetArray();

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
    #print_r($passed_params)."<br>";
    
    #---------------------------------------------------------------
    # Filtro POLI
    // $poli = $passed_params["poli"];
    // $filtro_poli = "";
    // if (count($poli)) {
        // $filtro_poli = " AND codice_polo IN ('".implode("','", $poli)."')";
    // }
    // elseif (strlen(trim($poli)) > 0)
        // $filtro_poli = " AND codice_polo='".trim($poli)."'";
        
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
    $sql = "SELECT DISTINCT top 1000 codice_polo, polo, codice_edificio, edificio, indirizzo, codice_piano, piano, 
            codice_locale, locale, mq_locale, codice_categoria, categoria, codice_ddu, ddu, /*codice_struttura, struttura, codice_ugov, */
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

#
# LOCALE
#
$this->respond('GET', '/[:locale]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI, $operatore;
    $session = getSession();
    $db = getDB();
    $codice_locale = $request->locale;

    #---------------------------------------------------------------
    # INFO LOCALE
    $sql = "SELECT DISTINCT top 1000 codice_polo, polo, codice_edificio, edificio, indirizzo, codice_piano, piano, 
            codice_locale, locale, mq_locale, codice_categoria, categoria, codice_ddu, ddu, /*codice_struttura, struttura, codice_ugov, */
            capienza, latitudine, longitudine, fotoprinc
            FROM {$DBMODULI}.BOOK_VW_Spazi
            WHERE codice_locale='{$codice_locale}'";
    $rs = $db->Esegui($sql);
    $spazi = array();
    if ($rs)
        $spazi = $rs->GetArray();

    #---------------------------------------------------------------
    # DDU
    $ddu = array();
    foreach($spazi as $item) {
        $code = $item["codice_ddu"];
        $ddu[$code] = $item["ddu"];
    }
    
    #---------------------------------------------------------------
    # FOTO
    $sql = "SELECT DISTINCT *
            FROM {$DBMODULI}.BOOK_FOTO
            WHERE codice_locale='{$codice_locale}'";
    $rs = $db->Esegui($sql);
    $foto = array();
    if ($rs)
        $foto = $rs->GetArray();
    
    #---------------------------------------------------------------
    # PERMESSI
    $permissions = array();
    $permissions["ALLOW_UPDATE_FOTO"] = false;
    #if (in_array(strtoupper($operatore->username()), array("C0707", "53698", "C1967")))
    #    $permissions["ALLOW_UPDATE_FOTO"] = true;
    
    #---------------------------------------------------------------
    #$session->smarty->assign("username", $operatore->username());
    $session->smarty->assign("permissions", $permissions);
    $session->smarty->assign("spazio", $spazi[0]);
    $session->smarty->assign("foto", $foto);
    $session->smarty->assign("ddu", $ddu);
    $session->smarty->display("spazi-locale.tpl");
});

#
# PLANIMETRIA DINAMICA DA REFTREE
#
$this->respond('GET', '/planimetrie/[:code]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI, $DBREFTREE;
    $session = getSession();
    $code_locale = $request->code;
    
    $db = getDB();
    $sql = "SELECT * FROM {$DBREFTREE}.core.AS_GET_ASSET_GET_HANDLE_FILENAME('us_{$code_locale}')";
    $rs = $db->Esegui($sql);
    $polilinea = array();
    if ($rs)
        $polilinea = $rs->GetArray();
    
    $nome_planimetria = $polilinea[0]["nome_file"];
    $handle = $polilinea[0]["handle"];
    
    #$db = getDB();
    
    #---------------------------------------------------------------
    # POLI
    // $sql = "SELECT codice_polo as code, polo as label
            // FROM {$DBMODULI}.dbo.BOOK_Poli";
    // $rs = $db->Esegui($sql);
    // $poli = array();
    // if ($rs)
        // $poli = $rs->GetArray();
    
    #---------------------------------------------------------------
    $input = array(
        "files" => array(
            array(
                "name" => $nome_planimetria,
                "polylines" => array(
                    array(
                        "handles" => array($handle),
                        "color" => "#00b3b3"
                    )
                )
            )
        )
    );
    // $input = {"files":[{"name":"635826573675032606_16125-01-01-I.zip","polylines":[{"handles":["2C340"],"color":"#FF0000"},{"handles":["2C333"],"color":"#FFFF00"}]}]}
    $stringa = json_encode($input);
    $method = "AES-128-CBC";
    $byteKey = base64_decode("7NUNzhs2O5Kg3E0TVmrZbw==");
    $ivlen = openssl_cipher_iv_length($method);
    $byteIV = openssl_random_pseudo_bytes($ivlen);
    
    $stringa_da_cifrare = $byteIV.$stringa;
    $enc_stringa = openssl_encrypt ($stringa_da_cifrare, $method, $byteKey, 0, $byteIV);
    $urlq = urlencode($enc_stringa);
    $url = "http://dev.reftree.it/api/DWG/Viewer?q=";
    #---------------------------------------------------------------
    $session->smarty->assign("url", $url);
    $session->smarty->assign("urlq", $urlq);
    header("Location:".$url.$urlq);
    exit();
    $session->smarty->display("spazi-planimetria.tpl");
});


#
# UPDATE FOTO
#
$this->respond('GET', '/update/foto/[:locale]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $db = getDB();
    $codice_locale = $request->locale;
    
    #---------------------------------------------------------------
    # FOTO
    $sql = "SELECT DISTINCT *
            FROM {$DBMODULI}.BOOK_FOTO
            WHERE codice_locale='{$codice_locale}'";
    $rs = $db->Esegui($sql);
    $foto = array();
    if ($rs)
        $foto = $rs->GetArray();
    
    #---------------------------------------------------------------
    $session->smarty->assign("foto", $foto);
    $session->smarty->assign("codice_locale", $codice_locale);
    $session->smarty->display("spazi-form-foto.tpl");
});
#==========================================================================================================
$this->respond('POST', '/update/foto/[:locale]', function ($request, $response, $service, $app) {
    GLOBAL $DBMODULI;
    $session = getSession();
    $codice_locale = $request->locale;
    $session->log("POST /spazi/update/foto/".$codice_locale);
    $db = getDB();
    
    #---------------------------------------------------------------
    # FOTO
    $sql = "SELECT DISTINCT *
            FROM {$DBMODULI}.BOOK_FOTO
            WHERE codice_locale='{$codice_locale}'";
    $rs = $db->Esegui($sql);
    $foto = array();
    if ($rs)
        $foto = $rs->GetArray();
    
    if (strlen($_FILES["foto_nuova"]["name"])) {
        
        $session->log("Foto nuova");
        
        $res = upload_image("foto_nuova", $codice_locale."_9", null, array('JPG'));
        if ($res) {
            $newfile = $res["name"].".".strtolower($res["extension"]);
            
            $sql = "INSERT INTO {$DBMODULI}.BOOK_Foto (codice_locale, foto, dt)
                    VALUES('{$codice_locale}', '{$newfile}', getdate())";
            $session->log($sql);
            $rs = $db->Esegui($sql);
        }
    }
    foreach($foto as $key => $item) {
        if (strlen($_FILES["foto".$key]["name"]) == 0) 
            continue;
        
        $session->log("Foto {$key}");
        $res = upload_image("foto{$key}", $codice_locale."_{$key}", $item["foto"], array('JPG'));
        if ($res) {
            $newfile = $res["name"].".".strtolower($res["extension"]);
            
            $sql = "UPDATE {$DBMODULI}.BOOK_Foto 
                    SET foto='{$newfile}', dt=getdate()
                    WHERE codice_locale='{$codice_locale}' AND foto='{$item["foto"]}'";
            $session->log($sql);
            $rs = $db->Esegui($sql);
        }
    } 
   
    header("Location:".ROOT_DIR.APP_BASE_URL."/spazi/".$codice_locale);
    exit();
});


?>