<?php

/************************************************************************************
* classe User
************************************************************************************/
class User extends Meta {
	private $m_attributi;
	
	################################################
	# Costruttore.
	public function __construct() {
		parent::__construct();
		
		$this->_fields["gruppi"] = array();
		$this->_fields["moduli"] = array();
	}
	
	################################################
	# GET
	public function id() {
		return $this->get($this->m_identity);
	}
	public function username() {
		return $this->get('username');
	}
	public function nominativo() {
		return $this->label();
	}
	public function label() {
		return $this->get('label');
	}
	public function matricola() {
		return $this->m_attributi['matricola'];
	}
	public function email() {
		if (strlen($this->get("email")) > 0)
			return $this->get("email");
		return $this->m_attributi['email'];
	}
	public function ou() {
		return $this->m_attributi['ou'];
	}
	public function struttura() {
		return $this->m_attributi['struttura'];
	}
	public function dn() {
		return $this->m_attributi['dn'];
	}
	public function attributi() {
		return $this->m_attributi;
	}
	public function amministratore() {
		return toBool($this->get("flag_admin"));
	}
	public function manager($codice_modulo) {
		return $this->amministratore() || $this->m_moduli[$codice_modulo]["manager"];
	}
	public function moduli() {
		return  $this->m_moduli;
	}
	public function modulo($codice_modulo) {
		if ($this->amministratore())
			return true;
		if (!isset($this->m_moduli[$codice_modulo]))
			return false;
		return  $this->m_moduli[$codice_modulo]["visibile"];
	}
	public function gruppi() {
		return $this->m_gruppi;
	}
	public function gruppo($codice_gruppo) {
		#if ($this->amministratore())
		#	return true;
		if (!isset($this->m_gruppi[$codice_gruppo]))
			return false;
		return  true;
	}

	################################################
	public function docente() {
		return $this->gruppo("DOCENTI") || $this->gruppo("faculty");
	}
	public function IsDocente() {
		return $this->docente();
	}
	public function segretario() {
		return $this->gruppo("SEGRETARI");
	}
	public function IsSegretario() {
		return $this->gruppo("SEGRETARI");
	}
  
	

	################################################
	# SET
	public function addManager($codice_modulo) {
		$this->m_moduli[$codice_modulo]["manager"] = true;
		return true;
	}
	public function addModulo($codice_modulo) {
		$this->m_moduli[$codice_modulo]["visibile"] = true;
		return true;
	}
	public function addGruppo($codice_gruppo) {
		$this->m_gruppi[$codice_gruppo] = $codice_gruppo;
		return true;
	}

}
?>
