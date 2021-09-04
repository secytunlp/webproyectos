<?php
	
	class Integrante {
		private $cd_proyecto;
		private $dt_alta;
		private $dt_baja;
		private $cd_tipoinvestigador;
		private $cd_estado;
		private $cd_docente;
		private $ds_investigador;
		private $ds_categoria;
		private $nu_dedinv;
		private $ds_deddoc;
		private $ds_facultad;
		private $nu_horasinv;
		private $dt_altapendiente;
		private $dt_bajapendiente;
		private $bl_insertado;
		private $ds_curriculum;
		private $ds_actividades;
		private $ds_consecuencias;
		private $ds_motivos;
		
		private $nu_horasinvAnt;
		private $dt_cambioHS;
		
		private $ds_reduccionHS;
		//Método constructor 
		

		function Integrante() {
			
			$this->cd_proyecto = 0;
			$this->dt_baja = '';
			$this->cd_tipoinvestigador = '';
			
			$this->dt_alta = '';
			$this->cd_docente = '';
			$this->cd_estado = 0;
			$this->ds_investigador= '';
			$this->ds_categoria= '';
			$this->nu_dedinv= '';
			$this->ds_deddoc= '';
			$this->ds_facultad= '';
			$this->dt_altapendiente = '';
			$this->dt_bajapendiente = '';
			$this->nu_horasinv = '';
			$this->bl_insertado = 0;
			$this->ds_curriculum= '';
			$this->ds_actividades= '';
			$this->ds_consecuencias= '';
			$this->ds_motivos= '';
			$this->nu_horasinvAnt = 0;
			$this->dt_cambioHS= '';
			
			$this->ds_reduccionHS= '';
		}
		
		//Métodos Get 
		

		function getCd_proyecto() {
			return $this->cd_proyecto;
		}
		
		function getCd_docente() {
			return $this->cd_docente;
		}
		
		function getCd_estado() {
			return $this->cd_estado;
		}
		
		function getDt_alta() {
			return $this->dt_alta;
		}
		
		function getDt_baja() {
			return $this->dt_baja;
		}
		
		function getCd_tipoinvestigador() {
			return $this->cd_tipoinvestigador;
		}
		
		
		function getDs_investigador() {
			return $this->ds_investigador;
		}
		
		function getDs_categoria() {
			return $this->ds_categoria;
		}
		
		function getNu_dedinv() {
			return $this->nu_dedinv;
		}
		
		function getDs_deddoc() {
			return $this->ds_deddoc;
		}
		
		function getDs_facultad() {
			return $this->ds_facultad;
		}
		
		function getDt_altapendiente() {
			return $this->dt_altapendiente;
		}
		
		function getDt_bajapendiente() {
			return $this->dt_bajapendiente;
		}
		
		function getNu_horasinv() {
			return $this->nu_horasinv;
		}
		
		function getBl_insertado() {
			return $this->bl_insertado;
		}
		
		function getDs_curriculum() {
			return $this->ds_curriculum;
		}
		
		function getDs_actividades() {
			return $this->ds_actividades;
		}
		
		function getDs_consecuencias() {
			return $this->ds_consecuencias;
		}
		
		
		//Métodos Set 
		

		function setCd_proyecto($value) {
			$this->cd_proyecto = $value;
		}
		
		function setCd_docente($value) {
			$this->cd_docente = $value;
		}
		
		function setCd_estado($value) {
			$this->cd_estado = $value;
		}
		
		function setDt_alta($value) {
			$this->dt_alta = $value;
		}
		
		function setDt_baja($value) {
			$this->dt_baja = $value;
		}
		
		function setCd_tipoinvestigador($value) {
			$this->cd_tipoinvestigador = $value;
		}
		
		
		function setDs_investigador($value) {
			$this->ds_investigador = $value;
		}
		
		function setDs_categoria($value) {
			$this->ds_categoria = $value;
		}
		
		function setNu_dedinv($value) {
			$this->nu_dedinv = $value;
		}
		
		function setDs_deddoc($value) {
			$this->ds_deddoc = $value;
		}
		
		function setDs_facultad($value) {
			$this->ds_facultad = $value;
		}
		
		function setDt_altapendiente($value) {
			$this->dt_altapendiente = $value;
		}
		
		function setDt_bajapendiente($value) {
			$this->dt_bajapendiente = $value;
		}
		
		function setNu_horasinv($value) {
			$this->nu_horasinv = $value;
		}
		
		function setBl_insertado($value) {
			$this->bl_insertado = $value;
		}
		
		function setDs_curriculum($value) {
			$this->ds_curriculum = $value;
		}
		
		function setDs_actividades($value) {
			$this->ds_actividades = $value;
		}
		
		function setDs_consecuencias($value) {
			$this->ds_consecuencias = $value;
		}
		
	
	
			public function getDs_motivos()
			{
			    return $this->ds_motivos;
			}

			public function setDs_motivos($ds_motivos)
			{
			    $this->ds_motivos = $ds_motivos;
			}

		public function getNu_horasinvAnt()
		{
		    return $this->nu_horasinvAnt;
		}

		public function setNu_horasinvAnt($nu_horasinvAnt)
		{
		    $this->nu_horasinvAnt = $nu_horasinvAnt;
		}

		public function getDt_cambioHS()
		{
		    return $this->dt_cambioHS;
		}

		public function setDt_cambioHS($dt_cambioHS)
		{
		    $this->dt_cambioHS = $dt_cambioHS;
		}

		

		public function getDs_reduccionHS()
		{
		    return $this->ds_reduccionHS;
		}

		public function setDs_reduccionHS($ds_reduccionHS)
		{
		    $this->ds_reduccionHS = $ds_reduccionHS;
		}
}

