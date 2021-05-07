<?php
require_once(dirname(__FILE__)."/../inc/class/crud.php");
require_once(dirname(__FILE__)."/../inc/class/usuario.php");
require_once(dirname(__FILE__)."/../inc/class/direccion.php");
include_once(dirname(__FILE__)."/../inc/funciones.inc.php");
//Instanciamos un obj de clase Crud...
//
$crud = new Crud();
//Instanciamos un obj de clase usuario...
//
$usuario = new Usuario();
//Instanciamos un obj de clase direccion por cada direccion con la que trabajaremos...
//
$direccion = new Direccion();
$direccion_2 = new Direccion();
if(isset($_POST['datos']))
{
    if(!empty($_POST['datos']))
    {
    //Recogemos el Json que nos envía la vista y lo decodificamos para extraer sus valores como un array de keys...
    //
        $datos = json_decode($_POST['datos'] , true);
        $accion = $datos['accion'];
        $id = $datos['id'];
        //Según el valor de la accion que nos ha enviado la vista ejecutaremos una acción u otra...
        //
        if($accion == "FILTRAR")
        {
            //Recogemos el json con los datos offset , limit y caracteres que estructurarán la petición a BD...
            //
            $data = $_POST['datos'];
            $datos = json_decode($data , true);
            $bus_char = $datos['char'];
            $offset = $datos['offset'];
            $limit = $datos['limit'];
            $lista_datos = $crud->mostrar($bus_char , $offset , $limit);
            $json_respuesta = json_encode($lista_datos);
            header('Content-type: application/json; charset=utf-8');
            //Devolvemos un Json con todos los datos de los usuarios que debemos mostrar segun el offset , limit y char pasados anteriormente...
            //
            echo($json_respuesta);
        }
        elseif($accion == "MOSTRAR")
        {
            //En el caso de que no llegue informacion del id del usuario desde la vista encargada de recoger los valores del mismo para mostrarlos será 0 ,
            //en este caso devolveremos un mensaje de error...
            if($id == 0)
            {
                $r = array("respuesta"=>"No llega información del id...");
                $json_datos = json_encode($r);
                echo($json_datos);
            }
            else
            {
                //Obtenemos la información del usuario mediante los metodos de la clase crud obtener_us y obtener_direccion...
                //
                $usuario = $crud->obtener_us($id);
                $dom_fis = $crud->obtener_direccion($id , 1);
                $dom_soc = $crud->obtener_direccion($id , 2);
                //Metemos los datos recogidos en un array de keys y lo parseamos a formato Json para devolverlos a la vista y mostrarlos...
                //
                $r = array("usuario"=>$usuario , "dom_fis"=>$dom_fis , "dom_soc"=>$dom_soc);
                $json_datos = json_encode($r);
                echo($json_datos);

            }
        }
        elseif($accion == "ELIMINAR")
        {
            //Ejecutamos la eliminación del usuario mediante el metodo eliminar de la clase crud y recogemos la respuesta...
            //
            $respuesta = $crud->eliminar( $id );
            $r = array("respuesta"=>$respuesta);
            $json_respuesta = json_encode($r);
            echo($json_respuesta);
        }
        else
        //En el caso de que la acción recibida no sea eliminar o mostrar crearemos un obj con cada uno de los datos correspondientes que nos envía la vista...
        //
        {
           //Validamos que los datos personales considerados obligatorios para la gestión del usuario no estén vacíos ...
           //
            if($datos['dni'] == "" || 
                $datos['nombre'] == ""  || 
                $datos['primer_apellido'] == ""  || 
                $datos['segundo_apellido'] == ""  || 
                $datos['sexo'] == ""  || 
                $datos['fecha_nacimiento'] == ""  || 
                $datos['estado_civil'] == ""  || 
                $datos['email'] == ""  || 
                $datos['tlf'] == "" )
            {
            $respuesta = "Alguno de los datos personales del usuario esta vacio , reviselos...";
            $r = array("respuesta"=>$respuesta);
            $json_respuesta = json_encode($r);
            echo($json_respuesta);
            }
            //Validamos que los datos de la direccion fiscal considerados obligatorios para la gestión del usuario no estén vacíos ...
           //
            elseif($datos['tipo_via'] == ""  || 
                $datos['direccion'] == ""  || 
                $datos['numero'] == "" || 
                $datos['piso'] == ""  || 
                $datos['puerta'] == ""  ||  
                $datos['cod_postal'] == ""  || 
                $datos['provincia'] == ""  ||
                $datos['pais'] == "" )
            {
                $respuesta = "Alguno de los datos obligatorios de la direccion fiscal esta vacio , reviselos..."; 
                $r = array("respuesta"=>$respuesta);
                $json_respuesta = json_encode($r);
                echo($json_respuesta);
            }
            else
            //No es necesario validar la direccion social puesto que es opcional...
            //
            {       
                //Creamos el objeto usuario con los datos del json...
                //
                $usuario->setDni( $datos['dni'] );  
                $usuario->setNombre( $datos['nombre'] );  
                $usuario->setPrimer_apellido( $datos['primer_apellido'] );
                $usuario->setSegundo_apellido( $datos['segundo_apellido'] );
                $usuario->setSexo( $datos['sexo'] );
                $usuario->setFecha_nacimiento( $datos['fecha_nacimiento'] );
                $usuario->setEstado_civil( $datos['estado_civil'] );
                $usuario->setEmail( $datos['email'] );
                $usuario->setTelefono( $datos['tlf'] );
                //Creamos la direccion social...
                //
                $direccion->setTipo_via( $datos['tipo_via'] );
                $direccion->setDireccion( $datos['direccion'] );
                $direccion->setComp_direccion( $datos['comp_direccion'] );
                $direccion->setNumero( $datos['numero'] );
                $direccion->setPiso( $datos['piso'] );
                $direccion->setPuerta( $datos['puerta'] );
                $direccion->setEscalera(  $datos['escalera'] );
                $direccion->setCod_postal(  $datos['cod_postal'] );
                $direccion->setLocalidad( $datos['localidad'] );
                $direccion->setProvincia( $datos['provincia'] );
                $direccion->setPais( $datos['pais'] );
                //Creamos la direccion fiscal...
                //       
                $direccion_2->setTipo_via( $datos['tipo_via_2'] );
                $direccion_2->setDireccion( $datos['direccion_2'] );
                $direccion_2->setComp_direccion( $datos['comp_direccion_2'] );
                $direccion_2->setNumero( $datos['numero_2'] );
                $direccion_2->setPiso( $datos['piso_2'] );
                $direccion_2->setPuerta( $datos['puerta_2'] );
                $direccion_2->setEscalera(  $datos['escalera_2'] );
                $direccion_2->setCod_postal(  $datos['cod_postal_2'] );
                $direccion_2->setLocalidad( $datos['localidad_2'] );
                $direccion_2->setProvincia( $datos['provincia_2'] );
                $direccion_2->setPais( $datos['pais_2'] );  
                //En el caso de que la acción a ejecutar sea añadir un nuevo usuario...
                //  
                if($accion == "AÑADIR")
                {
                    //Añadimos el nuevo usuario con el metodo insertar de la clase crud y recogemos la respuesta...
                    //
                    $respuesta = $crud->insertar( $usuario , $direccion , $direccion_2 );
                    $r = array("respuesta" => $respuesta);
                    //Parseamos la respuesta y la enviamos a la vista...
                    //
                    $json_respuesta = json_encode($r);
                    echo($json_respuesta);
                }
                //En el caso de que la acción a ejecutar sea editar...
                //
                elseif($accion == "EDITAR")
                { 
                    //Validamos que el id del usuario a editar haya llegado correctamente...
                    //
                    if($id == 0)
                    {
                        $r = array("respuesta" => "No llega informacion del id del usuario");
                        $json_respuesta = json_encode($r);
                        echo($json_respuesta);
                    }
                    else
                    {
                        //Editamos el usuario con el motodo editar de la clase crud y recojemos la respuesta...
                        //
                        if($crud->editar( $usuario , $id , $direccion , $direccion_2 ) == true)
                        {
                            $respuesta = "Usuario modificado con exito";   
                            $r = array("respuesta" => $respuesta , "redireccionar" => "OK");
                        }
                        else 
                        {
                            $respuesta = "Error al editar al usuario";
                            $r = array("respuesta" => $respuesta);
                        }
                        //Parseamos la respuesta a formato Json y la devolvemos a la vista...
                        //
                        $json_respuesta = json_encode($r);
                        echo($json_respuesta);
                    }                    
                   
                }   
            } 
        }

    }
            
}   
    


?>