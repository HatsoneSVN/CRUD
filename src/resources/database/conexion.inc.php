<?php
	
	class  Db{

		private static $conexion=NULL;

		private function __construct (){}

 
		public static function conectar()
		{
			$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;

			self::$conexion= new PDO('mysql:host=timebus_mysql;dbname=REGISTRO','sa','P@ssw0rd',$pdo_options);
			
			return self::$conexion;
		}		
	} 

?>