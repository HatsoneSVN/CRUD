<?php
    class Direccion
    {
        //Declaramos todos los atributos que contendra el obj direccion...
        //
        public $id;
        public $tipo_via;  
        public $direccion;
        public $comp_direccion;       
        public $numero;
        public $piso ;
        public $puerta;
        public $escalera;
        public $cod_postal;
        public $localidad;
        public $provincia;
        public $pais;
        public $id_us;
        public $tipo_direccion;
        //Metodo constructor de la clase...
        //
		function __construct(){}
        //Creamos todos los getter y setter de cada atributo de la clase...
        //
        //via
        //
		public function getTipo_via(){
		return $this->tipo_via;
		}
		public function setTipo_via($tipo_via){
			$this->tipo_via = $tipo_via;
        }
        //dirección
        //
		public function getDireccion(){
			return $this->direccion;
        }
		public function setDireccion($direccion){
			$this->direccion = $direccion;
        }
        //complement dirección
        //
        public function getComp_direccion(){
			return $this->comp_direccion;
		}
		public function setComp_direccion($comp_direccion){
			$this->comp_direccion = $comp_direccion;
        }
        //número
        //
        public function getNumero(){
			return $this->numero;
		}
		public function setNumero($numero){
			$this->numero = $numero;
        }
        //piso
        //
		public function getpiso(){
		    return $this->piso;
		}
		public function setPiso($piso){
			$this->piso = $piso;
        }
        //puerta
        //
        public function getPuerta(){
            return $this->puerta;
        }
        public function setPuerta($puerta){
            $this->puerta = $puerta;
        }
        //escalera
        //
        public function setEscalera($escalera){
            $this->escalera = $escalera;
        }
        public function getEscalera(){
            return $this->escalera;
        }
        //cod_postal
        //
        public function setCod_postal($cod_postal){
            $this->cod_postal = $cod_postal;
        }
        public function getCod_postal(){
            return $this->cod_postal;
        }
        //localidad
        //
        public function setLocalidad($localidad){
            $this->localidad = $localidad;
        }
        public function getLocalidad(){
            return $this->localidad;
        }
        //provincia
        //
        public function setProvincia($provincia){
            $this->provincia = $provincia;
        }
        public function getProvincia(){
            return $this->provincia;
        }
        //país
        //
        public function setPais($pais){
            $this->pais = $pais;
        }
        public function getPais(){
            return $this->pais;
        }
        //id_us
        //
        public function setId_us($id_us){
            $this->id_us = $id_us;
        }
        public function getId_us(){
            return $this->id_us;
        }
        //tipo_direccion
        //
        public function setTipo_direccion($tipo_direccion){
            $this->tipo_direccion = $tipo_direccion;
        }
        public function getTipo_direccion(){
            return $this->tipo_direccion;
        }
    
    
	}
?>