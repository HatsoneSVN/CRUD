<?php
require_once(dirname(__FILE__)."/../inc/class/usuario.php");
include_once(dirname(__FILE__)."/../inc/funciones.inc.php");
require_once(dirname(__FILE__)."/../inc/class/crud.php");
//Iniciamos sesion...
//
$crud = new Crud();
session_start();
if(isset($_POST['datos']))
{
    if(!empty($_POST['datos']))
    {
        $datos = json_decode($_POST['datos'] , true);
        $accion = $datos['accion'];
        switch ($accion)
        {
            case "LOGIN":
                $nom_email = $datos['user'];
                $pass = $datos['pass'];    
                $respuesta = $crud->comp_login($nom_email , $pass);
                $respuesta = array("respuesta"=>$respuesta);
                $json_respuesta = json_encode($respuesta);
                echo($json_respuesta);
            break;
            case "REGISTER":
                $usuario = new Usuario($datos['email'] , $datos['user'] , $datos['pass']);
                $respuesta = $crud->register($usuario);
                $json_respuesta = json_encode($respuesta);
                echo($json_respuesta);
            break;
            case "SALIR":
                $respuesta = $crud->exit();
                $respuesta = array("respuesta"=>$respuesta);
                $json_respuesta = json_encode($respuesta);
                echo($json_respuesta);
            break;
            case "DATOS_US":
                $respuesta = array("nombre"=>$_SESSION['NOMBRE'] ,
                "email"=>$_SESSION['EMAIL'] , 
                "id"=>$_SESSION['ID'] , 
                "modificacion"=>$_SESSION['MODIFICACION']);
                $json_respuesta = json_encode($respuesta);
                echo($json_respuesta);
            break;
            case "UPD_US":
                $nombre = $datos['nombre'];
                $email = $datos['email'];
                $usuario = new Usuario($email , $nombre , $_SESSION['pass']);
                $respuesta = $crud->upd_us($usuario);
                $respuesta = array("respuesta"=>$respuesta);
                $json_respuesta = json_encode($respuesta);
                echo($json_respuesta);
            break;
            case "UPD_PASS":
                $nw_pass = $datos['pass'];
                $pass = $datos['pass_ant'];
                $usuario = new Usuario($_SESSION['EMAIL'] , $_SESSION['ID'] , $nw_pass);
                $respuesta = $crud->upd_pass($pass , $usuario);
                $respuesta = array("respuesta" => $respuesta);
                $json_respuesta = json_encode($respuesta);
                echo($json_respuesta);
            break;
        }
    }
    else
    {
        $respuesta = array("respuesta"=>"La información del login está vacía...");
        $json_respuesta = json_encode($respuesta);
        echo($json_respuesta);
    }
}
else
{
    $respuesta = array("respuesta"=>"No llega inforamción del login...");
    $json_respuesta = json_encode($respuesta);
    echo($json_respuesta);
}

?>