<?php

class Carrerainv {
	private $cd_carrerainv;
	private $ds_carrerainv;
	
	//M�todo constructor 
	

	function Carrerainv() {
		
		$this->cd_carrerainv = 0;
		$this->ds_carrerainv = '';
	}
	
	//M�todos Get 
	

	function getCd_carrerainv() {
		return $this->cd_carrerainv;
	}
	
	function getDs_carrerainv() {
		return $this->ds_carrerainv;
	}
	
	//M�todos Set 
	

	function setCd_carrerainv($value) {
		$this->cd_carrerainv = $value;
	}
	
	function setDs_carrerainv($value) {
		$this->ds_carrerainv = $value;
	}

}

