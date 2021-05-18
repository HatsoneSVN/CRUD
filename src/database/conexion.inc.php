<?php
/*require_once(dirname(__FILE__).'/../../vendor/autoload.php');
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
	$db_name=getenv('DB_NAME');
	$db_pass=getenv('DB_PASSWORD');
	$db_user=getenv('DB_USER');*/
	//Esta clase es la encargada de establecer la conexión con la base de datos...
	//
	class  Db{
		private static $conexion=NULL;
		private function __construct (){}
		//El metodo conectar nos conecta con la BD...
		//
		public static function conectar()
		{
			$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
			//self::$conexion= new PDO('mysql:host=timebus_mysql;dbname='.$db_name,$db_pass,$db_pass,$pdo_options);
			self::$conexion= new PDO('mysql:host=timebus_mysql;dbname=REGISTRO','sa','P@ssw0rd',$pdo_options);
			return self::$conexion;
		}		
	} 
?>