<?php

class Universidad {
	private $cd_universidad;
	private $ds_universidad;
	
	//M�todo constructor 
	

	function Universidad() {
		
		$this->cd_universidad = 0;
		$this->ds_universidad = '';
	}
	
	//M�todos Get 
	

	function getCd_universidad() {
		return $this->cd_universidad;
	}
	
	function getDs_universidad() {
		return $this->ds_universidad;
	}
	
	//M�todos Set 
	

	function setCd_universidad($value) {
		$this->cd_universidad = $value;
	}
	
	function setDs_universidad($value) {
		$this->ds_universidad = $value;
	}

}

