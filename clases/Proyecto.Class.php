<?php
	
	class Proyecto {
		private $cd_proyecto;
		private $ds_titulo;
		private $ds_codigo;
		private $dt_ini;
		private $dt_fin;
		private $dt_inc;
		private $cd_facultad;
		private $ds_facultad;
		private $ds_director;
		private $cd_director;
		private $nu_duracion;
		private $bl_altapendiente;
		private $bl_bajapendiente;
		private $ds_abstract1;
		private $ds_clave1;
		private $ds_clave2;
		private $ds_clave3;
		private $ds_clave4;
		private $ds_clave5;
		private $ds_clave6;
		private $ds_abstracteng;
		private $ds_claveeng1;
		private $ds_claveeng2;
		private $ds_claveeng3;
		private $ds_claveeng4;
		private $ds_claveeng5;
		private $ds_claveeng6;
		private $ds_campo;
		private $ds_linea;
		private $ds_tipo;
		private $ds_disciplina;
		private $ds_especialidad;
		//Método constructor 
		

		function Proyecto() {
			
			$this->cd_proyecto = 0;
			$this->ds_titulo = '';
			$this->ds_codigo = '';
			$this->dt_fin = '';
			$this->dt_inc = '';
			$this->dt_ini = '';
			$this->cd_facultad = '';
			$this->ds_facultad = '';
			$this->ds_director = '';
			$this->cd_director = '';
			$this->nu_duracion = '';
			$this->bl_altapendiente = 0;
			$this->bl_bajapendiente = 0;
			$this->ds_abstract1= '';
			$this->ds_clave1= '';
			$this->ds_clave2= '';
			$this->ds_clave3= '';
			$this->ds_clave4= '';
			$this->ds_clave5= '';
			$this->ds_clave6= '';
			$this->ds_abstracteng= '';
			$this->ds_claveeng1= '';
			$this->ds_claveeng2= '';
			$this->ds_claveeng3= '';
			$this->ds_claveeng4= '';
			$this->ds_claveeng5= '';
			$this->ds_claveeng6= '';
			$this->ds_campo= '';
			$this->ds_linea= '';
			$this->ds_tipo= '';
			$this->ds_disciplina= '';
			$this->ds_especialidad= '';
		}
		
		//Métodos Get 
		

		function getCd_proyecto() {
			return $this->cd_proyecto;
		}
		
		function getDs_titulo() {
			return $this->ds_titulo;
		}
		
		function getDs_codigo() {
			return $this->ds_codigo;
		}
		
		function getDs_facultad() {
			return $this->ds_facultad;
		}
		
		function getCd_facultad() {
			return $this->cd_facultad;
		}
		
		function getDt_ini() {
			return $this->dt_ini;
		}
		
		function getDt_fin() {
			return $this->dt_fin;
		}
		
		function getDt_inc() {
			return $this->dt_inc;
		}
		
		function getDs_director() {
			return $this->ds_director;
		}
		
		function getCd_director() {
			return $this->cd_director;
		}
		
		function getNu_duracion() {
			return $this->nu_duracion;
		}
		
		function getBl_altapendiente() {
			return $this->bl_altapendiente;
		}
		
		function getBl_bajapendiente() {
			return $this->bl_bajapendiente;
		}
		
		//Métodos Set 
		

		function setCd_proyecto($value) {
			$this->cd_proyecto = $value;
		}
		
		function setDs_titulo($value) {
			$this->ds_titulo = $value;
		}
		
		function setDs_codigo($value) {
			$this->ds_codigo = $value;
		}
		
		function setDs_facultad($value) {
			$this->ds_facultad = $value;
		}
		
		function setCd_facultad($value) {
			$this->cd_facultad = $value;
		}
		
		function setDt_ini($value) {
			$this->dt_ini = $value;
		}
		
		function setDt_fin($value) {
			$this->dt_fin = $value;
		}
		
		function setDt_inc($value) {
			$this->dt_inc = $value;
		}
		
		function setDs_director($value) {
			$this->ds_director = $value;
		}
		
		function setCd_director($value) {
			$this->cd_director = $value;
		}
		
		function setNu_duracion($value) {
			$this->nu_duracion = $value;
		}
		
		function setBl_altapendiente($value) {
			$this->bl_altapendiente = $value;
		}
		
		function setBl_bajapendiente($value) {
			$this->bl_bajapendiente = $value;
		}
	
	
			public function getDs_abstract1()
			{
			    return $this->ds_abstract1;
			}

			public function setDs_abstract1($ds_abstract1)
			{
			    $this->ds_abstract1 = $ds_abstract1;
			}

			public function getDs_clave1()
			{
			    return $this->ds_clave1;
			}

			public function setDs_clave1($ds_clave1)
			{
			    $this->ds_clave1 = $ds_clave1;
			}

			public function getDs_clave2()
			{
			    return $this->ds_clave2;
			}

			public function setDs_clave2($ds_clave2)
			{
			    $this->ds_clave2 = $ds_clave2;
			}

			public function getDs_clave3()
			{
			    return $this->ds_clave3;
			}

			public function setDs_clave3($ds_clave3)
			{
			    $this->ds_clave3 = $ds_clave3;
			}

			public function getDs_clave4()
			{
			    return $this->ds_clave4;
			}

			public function setDs_clave4($ds_clave4)
			{
			    $this->ds_clave4 = $ds_clave4;
			}

			public function getDs_clave5()
			{
			    return $this->ds_clave5;
			}

			public function setDs_clave5($ds_clave5)
			{
			    $this->ds_clave5 = $ds_clave5;
			}

			public function getDs_clave6()
			{
			    return $this->ds_clave6;
			}

			public function setDs_clave6($ds_clave6)
			{
			    $this->ds_clave6 = $ds_clave6;
			}

			public function getDs_abstracteng()
			{
			    return $this->ds_abstracteng;
			}

			public function setDs_abstracteng($ds_abstracteng)
			{
			    $this->ds_abstracteng = $ds_abstracteng;
			}

			public function getDs_claveeng1()
			{
			    return $this->ds_claveeng1;
			}

			public function setDs_claveeng1($ds_claveeng1)
			{
			    $this->ds_claveeng1 = $ds_claveeng1;
			}

			public function getDs_claveeng2()
			{
			    return $this->ds_claveeng2;
			}

			public function setDs_claveeng2($ds_claveeng2)
			{
			    $this->ds_claveeng2 = $ds_claveeng2;
			}

			public function getDs_claveeng3()
			{
			    return $this->ds_claveeng3;
			}

			public function setDs_claveeng3($ds_claveeng3)
			{
			    $this->ds_claveeng3 = $ds_claveeng3;
			}

			public function getDs_claveeng4()
			{
			    return $this->ds_claveeng4;
			}

			public function setDs_claveeng4($ds_claveeng4)
			{
			    $this->ds_claveeng4 = $ds_claveeng4;
			}

			public function getDs_claveeng5()
			{
			    return $this->ds_claveeng5;
			}

			public function setDs_claveeng5($ds_claveeng5)
			{
			    $this->ds_claveeng5 = $ds_claveeng5;
			}

			public function getDs_claveeng6()
			{
			    return $this->ds_claveeng6;
			}

			public function setDs_claveeng6($ds_claveeng6)
			{
			    $this->ds_claveeng6 = $ds_claveeng6;
			}

		public function getDs_campo()
		{
		    return $this->ds_campo;
		}

		public function setDs_campo($ds_campo)
		{
		    $this->ds_campo = $ds_campo;
		}

		public function getDs_linea()
		{
		    return $this->ds_linea;
		}

		public function setDs_linea($ds_linea)
		{
		    $this->ds_linea = $ds_linea;
		}

		public function getDs_tipo()
		{
		    return $this->ds_tipo;
		}

		public function setDs_tipo($ds_tipo)
		{
		    $this->ds_tipo = $ds_tipo;
		}

		public function getDs_disciplina()
		{
		    return $this->ds_disciplina;
		}

		public function setDs_disciplina($ds_disciplina)
		{
		    $this->ds_disciplina = $ds_disciplina;
		}

		public function getDs_especialidad()
		{
		    return $this->ds_especialidad;
		}

		public function setDs_especialidad($ds_especialidad)
		{
		    $this->ds_especialidad = $ds_especialidad;
		}
}

