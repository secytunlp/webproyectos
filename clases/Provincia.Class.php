<?php

class Provincia {
	private $cd_provincia;
	private $ds_provincia;
	
	//M�todo constructor 
	

	function Provincia() {
		
		$this->cd_provincia = 0;
		$this->ds_provincia = '';
	}
	
	//M�todos Get 
	

	function getCd_provincia() {
		return $this->cd_provincia;
	}
	
	function getDs_provincia() {
		return $this->ds_provincia;
	}
	
	//M�todos Set 
	

	function setCd_provincia($value) {
		$this->cd_provincia = $value;
	}
	
	function setDs_provincia($value) {
		$this->ds_provincia = $value;
	}

}

