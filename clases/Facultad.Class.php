<?php

class Facultad {
	private $cd_facultad;
	private $ds_facultad;
	
	//M�todo constructor 
	

	function Facultad() {
		
		$this->cd_facultad = 0;
		$this->ds_facultad = '';
	}
	
	//M�todos Get 
	

	function getCd_facultad() {
		return $this->cd_facultad;
	}
	
	function getDs_facultad() {
		return $this->ds_facultad;
	}
	
	//M�todos Set 
	

	function setCd_facultad($value) {
		$this->cd_facultad = $value;
	}
	
	function setDs_facultad($value) {
		$this->ds_facultad = $value;
	}

}

