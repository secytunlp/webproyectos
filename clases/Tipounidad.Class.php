<?php

class Tipounidad {
	private $cd_tipounidad;
	private $ds_tipounidad;
	
	//M�todo constructor 
	

	function Tipounidad() {
		
		$this->cd_tipounidad = 0;
		$this->ds_tipounidad = '';
	}
	
	//M�todos Get 
	

	function getCd_tipounidad() {
		return $this->cd_tipounidad;
	}
	
	function getDs_tipounidad() {
		return $this->ds_tipounidad;
	}
	
	//M�todos Set 
	

	function setCd_tipounidad($value) {
		$this->cd_tipounidad = $value;
	}
	
	function setDs_tipounidad($value) {
		$this->ds_tipounidad = $value;
	}

}

