<?php	
	class Perfilfuncion {
		private $cd_perfil;
		private $cd_funcion;
		
		//M�todo constructor 
		

		function Perfilfuncion() {			
			$this->cd_perfil = 0;
			$this->cd_funcion = '';
		}
		
		//M�todos Get 
		

		function getCd_perfil() {
			return $this->cd_perfil;
		}
		
		function getCd_funcion() {
			return $this->cd_funcion;
		}
		
		//M�todos Set 
		

		function setCd_perfil($value) {
			$this->cd_perfil = $value;
		}
		
		function setCd_funcion($value) {
			$this->cd_funcion = $value;
		}
	
	}
?>
