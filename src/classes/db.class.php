<?php
#require_once('include/funzioni_date.inc.php');

#
# Gestore: Marcello Trucco
# Data Creazione: 29.09.2004
# Data Ultima Modifica: 13.01.2010
# Versione: 0.1
#

/*
/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
\ Classe RS                                                  /
/                                                            \
\ Oggetto che descrive il recordset risultante di una query. /
/                                                            \
\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
*/
class RS {
	private $m_adorecordset;

	public function __call($name,  $arguments) {
	#	return call_user_func_array(array($this->m_adorecordset, $name), $arguments);
		DEBUG($name);
		print_r($arguments);
		DEBUG('');
		die();
	}
	public function __get($name) {
		return $this->m_adorecordset->$name;
	}
	#-----------------------------------------------------------------------------
	public function set($rs) {
		if (is_object($rs))
			$this->m_adorecordset = $rs;
	}
	public function get() {
		return $this->m_adorecordset;
	}
	#-----------------------------------------------------------------------------
	public function Fields($nomecampo) {
		switch (ADODB_ASSOC_CASE) {
			case 0: # lower
				$nomecampo = strtolower($nomecampo);
				break;
			case 1: # UPPER
				$nomecampo = strtoupper($nomecampo);
				break;
			
			default:# non faccio nulla.
				break;
		}
		return $this->m_adorecordset->Fields($nomecampo); #utf8_encode
	}

	public function RecordCount() {
		return $this->m_adorecordset->RecordCount();
	}
	public function FieldCount() {
		return $this->m_adorecordset->FieldCount();
	}
	public function FetchField($pos) {
		return $this->m_adorecordset->FetchField($pos);
	}


	public function MoveFirst() {
		if (get_class($this->m_adorecordset) == 'ADORecordSet_empty')
			return true;
		return $this->m_adorecordset->MoveFirst();
	}

	public function MoveNext() {
		if (get_class($this->m_adorecordset) == 'ADORecordSet_empty')
			return true;
		return $this->m_adorecordset->MoveNext();
	}

	public function Close() {
		return $this->m_adorecordset->Close();
	}

	public function GetArray() {
		if (get_class($this->m_adorecordset) == 'ADORecordSet_empty')
			return array();
		return $this->m_adorecordset->GetArray();
	}

	public function GetRows() {
		return $this->m_adorecordset->GetRows();
	}

	public function GetRow() {
		return $this->m_adorecordset->FetchRow();
	}

	public function FetchRow() {
		return $this->m_adorecordset->FetchRow();
	}
	
	public function LastPageNo() {
		return $this->m_adorecordset->LastPageNo();
	}
	public function AtFirstPage() {
		return $this->m_adorecordset->AtFirstPage();
	}
	public function AtLastPage() {
		return $this->m_adorecordset->AtLastPage();
	}
}

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC; //ADODB_FETCH_BOTH;
/*******************************************************************************

/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
\ Classe DB                                                /
/                                                          \
\ Oggetto che descrive il database.                        /
/                                                          \
\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
*/
class DB {
	public $link;
	private $db_type;
	private $last_error_code;
	private $last_error_message;

	private $db_name;
	private $db_host;
	private $db_user;

	private $m_querylist;
	private $m_langid;
	private $m_language;
	
	################################################
	# Costruttore.
	function __construct($db_type=DB_TYPE) {
		$this->db_type = $db_type;
	}
	
	################################################
	function __sleep() {
		return array("db_type", "db_name", "m_langid", "m_language");
	}
	
	################################################
	function __wakeup() {
		$this->Connetti();
		$this->Init();
	}

	################################################
	# GET
	function get($what) {
		switch ($what) {
			case 'type':
				return $this->db_type;
				break;

			case 'host':
				return $this->db_host;
				break;

			case 'user':
				return $this->db_user;
				break;

			case 'database':
				return $this->db_name;
				break;

			case 'langid':
				return $this->m_langid;
				break;

			case 'language':
				return $this->m_language;
				break;
		}
	}
 
	################################################
	# Connetti:
	function Connetti($host=DB_HOST_SERVER, $user=DB_USERNAME, $pwd=DB_PASSWORD, $nomedb="") {

		if (strlen($nomedb) > 0)
			$this->db_name = $nomedb;
		elseif (isset($_SESSION["DB_NAME"]) && strlen($_SESSION["DB_NAME"]) > 0)
			$this->db_name = $_SESSION["DB_NAME"];
		else
			$this->db_name = DB_NAME;

		$this->db_host = $host;
		$this->db_user = decifra($user);

		// Creo la connessione:
		$this->link = ADONewConnection($this->db_type);
		#$this->link->charPage = 65001;

		$res = $this->link->PConnect($host, decifra($user), decifra($pwd), $this->db_name);
		#DEBUG("$host, $user, $pwd, $nomedb");
		#DEBUG("$host, ".decifra($user).", ".decifra($pwd).", $this->db_name");
		return $res;
	}

	################################################
	# Init:
	function Init() {
		if ($this->db_type == "mssql") {
			$this->Esegui("SET ANSI_WARNINGS ON", false);
			$this->Esegui("SET ANSI_NULLS ON", false);
			$this->Esegui("SET ANSI_NULL_DFLT_ON ON", false);

			if (strlen($this->m_language) == 0) {
				$rs = $this->Esegui("SELECT @@langid as code, @@language as label", true);
				if ($rs != FALSE) {
					$this->m_langid = strtolower(substr($rs->Fields("label"), 0, 2));
					$this->m_language = $rs->Fields("label");
				}
			}
		}
	}
 
	################################################
	# Disconnetti:
	function Disconnetti() {
		$res = $this->link->Disconnect();
		StampaErrore($res, "Disconnessione fallita.", true);
		return $res;
	}
 
	################################################
	# Esegui:
	function Esegui($strSQL, $logga=true, $titolo='SQL') {
		$operatore = getUser();
		
		if (strlen($strSQL) == 0)
			return true;

		if ($this->TransNo() > 0 && $this->HasFailedTrans()) {
			$this->m_querylist .= "*** NOT EXEC *** ".$strSQL."<br>\n";
			#DEBUG("<span style='color:red;'>FAIL TRANS - $strSQL<br>{$this->link->ErrorMsg()}</span>");
			return false;
		}

		$res = $this->link->Execute($strSQL);
		
		if ($res == FALSE) {
			SendMail("marcello@unige.it", "WM::Unige - Errore di esecuzione", "[".$this->last_error_code."] ".$this->last_error_message."\r\n".$strSQL."\r\nUsername: ".$operatore->username()."\r\nPagina: ".$_SERVER['PHP_SELF']);
      #DEBUG("<span style='color:red;'>FAIL - $strSQL<br>{$this->link->ErrorMsg()}</span>");
			$this->last_error_code = $this->link->ErrorNo();
			$this->last_error_message = $this->link->ErrorMsg();
			$this->Logga(LOGERROR, "[".$this->last_error_code."] ".$this->last_error_message, $strSQL);
			return FALSE;
		}
		elseif ($logga) {
			#DEBUG("OK - $strSQL");
			$this->Logga(LOGINFO, "$titolo ({$res->RecordCount()})", $strSQL);
		}

		if ($res != FALSE) {
			$rs = new RS();
			$rs->set($res);
			return $rs;
		}
		else
			return FALSE;
		#return $res;
	}
 
	################################################
	# Execute:
	function Execute($sql, $params=false, $logga=true, $titolo='SQL') {
        if (strlen($sql) == 0)
			return true;
        
        $res = $this->link->Execute($sql, $params);
        
        if ($res != FALSE) {
			$rs = new RS();
			$rs->set($res);
			return $rs;
		}
		else
			return FALSE;
        
        
        
        /*
		$operatore = getUser();
		
		if ($this->TransNo() > 0 && $this->HasFailedTrans()) {
			$this->m_querylist .= "*** NOT EXEC *** ".$strSQL."<br>\n";
			#DEBUG("<span style='color:red;'>FAIL TRANS - $strSQL<br>{$this->link->ErrorMsg()}</span>");
			return false;
		}

		if ($res == FALSE) {
			SendMail("marcello@unige.it", "WM::Unige - Errore di esecuzione", "[".$this->last_error_code."] ".$this->last_error_message."\r\n".$strSQL."\r\nUsername: ".$operatore->username()."\r\nPagina: ".$_SERVER['PHP_SELF']);
            #DEBUG("<span style='color:red;'>FAIL - $strSQL<br>{$this->link->ErrorMsg()}</span>");
			$this->last_error_code = $this->link->ErrorNo();
			$this->last_error_message = $this->link->ErrorMsg();
			$this->Logga(LOGERROR, "[".$this->last_error_code."] ".$this->last_error_message, $strSQL);
			return FALSE;
		}
		elseif ($logga) {
			#DEBUG("OK - $strSQL");
			$this->Logga(LOGINFO, "$titolo ({$res->RecordCount()})", $strSQL);
		}

		
		#return $res;
        */
	}

	################################################
	# Paginazione:
	function Paginazione($sql, $righe_per_pagina=1000000, $pagina_voluta=1) {
		if (strlen($sql) == 0)
			return false;

		$res = $this->link->PageExecute($sql, $righe_per_pagina, $pagina_voluta);

		if ($res == FALSE) {
			#DEBUG("FAIL - $sql");
			$this->last_error_code = $this->link->ErrorNo();
			$this->last_error_message = $this->link->ErrorMsg();
			$this->Logga(LOGERROR, "SQL - PageExecute [".$this->last_error_code."] ".$this->last_error_message, $sql);
			return FALSE;
		}
		else {
			#DEBUG("OK - $sql");
			$this->Logga(LOGINFO, "SQL - PageExecute ({$res->RecordCount()})", $sql);
		}

		if ($res != FALSE) {
			$rs = new RS();
			$rs->set($res);
			return $rs;
		}
		else
			return FALSE;

		#return $res;
	}

 ################################################
 # EseguiSP:
 function EseguiSP($spname, $param_values, $param_names) 
 {
 	if (!is_array($param_values) || !is_array($param_names))
 		return FALSE;
 	if (count($param_values) != count($param_names))
 		return FALSE;
 	if (count($param_values) == 0)
 		return $this->Esegui($spname);
 	
 	$stmt = $this->link->PrepareSP($spname);
 	
 	$params = " ";
	for ($i=0; $i < count($param_values); $i++) {
		$this->link->InParameter($stmt, $param_values[$i], $param_names[$i]);
		$params .= $param_names[$i]."=".$param_values[$i].", ";
	}
	$res = $this->link->Execute($stmt);
 	
 	if ($res == FALSE) {
 		$this->last_error_code = $this->link->ErrorNo();
 		$this->last_error_message = $this->link->ErrorMsg();
  	$this->Logga(LOGERROR, "[".$this->last_error_code."] ".$this->last_error_message, $spname.$params);
	}
	else {
		$this->Logga(LOGINFO, "SP", $spname.$params);
	}

	if ($res != FALSE) {
		$rs = new RS();
		$rs->set($res);
		return $rs;
	}
	else
		return FALSE;
	#return $res;
 }
 
 ################################################
 # Logga:
 function Logga($tipo, $desc, $cmd="") {
 	GLOBAL $operatore, $applicazione;

	
 }
 
	################################################
	# ErrorNo:
	function ErrorNo() {
		return $this->last_error_code;
	}
	
	################################################
	# ErrorMsg:
	function ErrorMsg() {
		return $this->last_error_message;
	}
	
	################################################
	# StartTrans:
	function StartTrans($mode="SERIALIZABLE") {
		$this->link->SetTransactionMode($mode);
		return $this->link->StartTrans(); # <-- INIZIO TRANSAZIONE.
	}
	
	################################################
	# CompleteTrans:
	function CompleteTrans($autocomplete=true) {
		$res = $this->link->CompleteTrans($autocomplete); # <-- FINE TRANSAZIONE.
		if ($this->TransNo() == 0) {
			Factory::conferma($res);
			
			if (strlen($this->m_querylist) > 0) {
				if ($res)
					$this->Logga(LOGINFO, "TRANSAZIONE OK", $this->m_querylist);
				else
					$this->Logga(LOGERROR, "TRANSAZIONE FALLITA!", $this->m_querylist);
				$this->m_querylist = "";
			}
		}

		return $res;
	}

	################################################
	# CompleteTrans:
	function HasFailedTrans() {
		return $this->link->HasFailedTrans(); # <-- CHECK FINE TRANSAZIONE.
	}

	################################################
	# CompleteTrans:
	function FailTrans() {
		#$this->Esegui("INSERT INTO TABELLACHENONESISTE VALUES('pippo', 'pluto', 'topolino')");
		return $this->link->FailTrans(); # <-- FORZO ROLLBACK.
	}

	function TransNo() {
		return $this->link->transCnt;
	}
	
	function FailAllTrans() {
		if ($this->TransNo() > 0) {
			$this->FailTrans();

			while ($this->TransNo() > 0)
				$this->CompleteTrans();
		}
	}

	################################################
	# :
	function DbName() {
		return $this->db_name;
	}

	function Data($data) {
		# DATA E' ITALIANA
		if (check_date_format($data, 'it')) {
			if ($this->m_langid == 'it')
				;
			else
				$data = date_translate($data, 'it', 'us');
		}
		# DATA NON E' ITALIANA
		elseif (check_date_format($data, 'us')) {
			if ($this->m_langid == 'it')
				$data = date_translate($data, 'us', 'it');
			else
				;
		}
		else
			$data = "";


		return $data;
	}
}
?>
