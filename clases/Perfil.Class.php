<?php

class Perfil {
	private $cd_perfil;
	private $ds_perfil;
	
	//M�todo constructor 
	

	function Perfil() {
		
		$this->cd_perfil = 0;
		$this->ds_perfil = '';
	}
	
	//M�todos Get 
	

	function getCd_perfil() {
		return $this->cd_perfil;
	}
	
	function getDs_perfil() {
		return $this->ds_perfil;
	}
	
	//M�todos Set 
	

	function setCd_perfil($value) {
		$this->cd_perfil = $value;
	}
	
	function setDs_perfil($value) {
		$this->ds_perfil = $value;
	}

}

