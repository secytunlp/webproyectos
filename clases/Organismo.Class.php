<?php

class Organismo {
	private $cd_organismo;
	private $ds_organismo;
	
	//M�todo constructor 
	

	function Organismo() {
		
		$this->cd_organismo = 0;
		$this->ds_organismo = '';
	}
	
	//M�todos Get 
	

	function getCd_organismo() {
		return $this->cd_organismo;
	}
	
	function getDs_organismo() {
		return $this->ds_organismo;
	}
	
	//M�todos Set 
	

	function setCd_organismo($value) {
		$this->cd_organismo = $value;
	}
	
	function setDs_organismo($value) {
		$this->ds_organismo = $value;
	}

}

