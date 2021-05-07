<?php
require_once(dirname(__FILE__)."/../../database/conexion.inc.php");
    class Usuario
    {
    //Cramos todos los atr de la clase usuario...
    //
        public $id;     
        public $nombre;       
        public $primer_apellido;     
        public $segundo_apellido;
        public $dni;
        public $sexo;
        public $fecha_nacimiento;
        public $estado_civil;
        public $email;
        public $telefono;
        public $rows;
        //Creamos el metodo constructor de la clase...
        //
        public function __construct(){}
        //Creamos todos los getter y setter de la los atr de la clase...
        //
        //nombre
        //
		public function getNombre(){
		return $this->nombre;
		}
		public function setNombre($nombre){
			$this->nombre = $nombre;
        }
        //primer_apellido
        //
		public function getPrimer_apellido(){
			return $this->primer_apellido;
		}
		public function setPrimer_apellido($primer_apellido){
			$this->primer_apellido = $primer_apellido;
		}
        //segundo_apellido
        //
        public function getSegundo_apellido(){
			return $this->segundo_apellido;
		}
		public function setSegundo_apellido($segundo_apellido){
			$this->segundo_apellido = $segundo_apellido;
		}
        //DNI
        //
		public function getDni(){
		    return $this->dni;
		}
		public function setDni($dni){
			$this->dni = $dni;
        }
        //Sexo
        //
        public function getSexo(){
            return $this->sexo;
        }
        public function setSexo($sexo){
            $this->sexo = $sexo;
        }
        //fecha
        //
        public function getFecha_nacimiento(){
            return $this->fecha_nacimiento;
        }
        public function setFecha_nacimiento($fecha_nacimiento){
            $this->fecha_nacimiento = $fecha_nacimiento;
        }
        //estado civil
        //
        public function getEstado_civil(){
            return $this->estado_civil;
        }
        public function setEstado_civil($estado_civil){
            $this->estado_civil = $estado_civil;
        }
        //email
        //
        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        //teléfono
        //
        public function getTelefono(){
            return $this->telefono;
        }
        public function setTelefono($telefono){
            $this->telefono = $telefono;
        }
        //ID
        //
        public function getId(){
			return $this->id;
		}
        public function setId($id){
			$this->id = $id;
        }
        //rows
        //
        public function getRows(){
			return $this->rows;
        }
        public function setRows($rows){
			$this->rows = $rows;
        }
        //Metodo que ejecuta una sentencia sql para recoger el número total de usuarios dándole su valor al atr rows de la clase us...
        //
        public function RowsTotal($bus_char)
        {
            $db=Db::conectar();
            if(empty($bus_char))
            {
                $select=$db->query(" SELECT * FROM REGISTRO.USUARIOS");
            }
            else
            {
                $select=$db->query(" SELECT * FROM REGISTRO.USUARIOS 
                WHERE 
                id_us LIKE '%$bus_char%' 
                OR 
                dni LIKE '%$bus_char%' 
                OR
                nombre LIKE '%$bus_char%' 
                OR 
                primer_apellido LIKE '%$bus_char%' 
                OR 
                segundo_apellido LIKE '%$bus_char%' 
                OR 
                email LIKE '%$bus_char%'
                OR 
                tlf LIKE '%$bus_char%'");
            }
            $rows = $select->rowCount();
            $this->rows = $rows;
        }
	}
?>