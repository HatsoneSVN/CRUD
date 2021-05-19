<?php

require_once(dirname(__FILE__)."/../../../database/conexion.inc.php");
include_once(dirname(__FILE__)."/../funciones.inc.php");
    class Usuario
    {
        public $id;
        public $fecha_creacion;
        public $fecha_modificacion;
        public $email;
        public $nombre;
        public $pass;
        //Constructor usuario...
        //
        function __construct( $email , $nombre , $pass){
            $this->email = $email;
            $this->nombre = $nombre;
            $pass_sha1 = password_hash($pass , PASSWORD_BCRYPT);
            $this->pass = $pass_sha1;
        }
        /*ALTER TABLE CLIENTES ADD FOREIGN KEY (id_us) REFERENCES CLIENTES (id_us);*/
        //getter y setter....
        //
        public function getId(){
            return $this->id;
        }
        public function setId($id){
             $this->id = $id;
        }
        public function getFecha_creacion(){
            return $this->fecha_creacion;
        }
        public function setFecha_creacion($fecha_creacion){
             $this->fecha_creacion = $fecha_creacion;
        }
        public function getFecha_modificacion(){
            return $this->fecha_modificacion;
        }
        public function setTipo_via($fecha_modificacion){
             $this->fecha_modificacion = $fecha_modificacion;
        }
        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
             $this->email = $email;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre){
             $this->nombre = $nombre;
        }
        public function getPass(){
            return $this->pass;
        }
        public function setPass($pass){
            $pass_sha1 = password_hash($pass , PASSWORD_BCRYPT);
             $this->pass = $pass_sha1;
        }
    }
?>