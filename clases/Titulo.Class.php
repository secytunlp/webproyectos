<?php

class Titulo {
	private $cd_titulo;
	private $ds_titulo;
	private $nu_nivel;
	private $cd_universidad;
	private $ds_universidad;
	
	//Método constructor 
	

	function Titulo() {
		
		$this->cd_titulo = 0;
		$this->ds_titulo = '';
		$this->nu_nivel = '';
		$this->cd_universidad = 0;
		$this->ds_universidad = '';
	}
	
	//Métodos Get 
	

	function getCd_titulo() {
		return $this->cd_titulo;
	}
	
	function getDs_titulo() {
		return $this->ds_titulo;
	}
	
	function getNu_nivel() {
		return $this->nu_nivel;
	}
	
	function getCd_universidad() {
		return $this->cd_universidad;
	}
	
	function getDs_universidad() {
		return $this->ds_universidad;
	}
	
	//Métodos Set 
	

	function setCd_titulo($value) {
		$this->cd_titulo = $value;
	}
	
	function setDs_titulo($value) {
		$this->ds_titulo = $value;
	}
	
	function setNu_nivel($value) {
		$this->nu_nivel = $value;
	}
	
	function setCd_universidad($value) {
		$this->cd_universidad = $value;
	}
	
	function setDs_universidad($value) {
		$this->ds_universidad = $value;
	}

}

