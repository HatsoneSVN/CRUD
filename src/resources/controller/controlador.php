<?php
require_once(dirname(__FILE__)."/../inc/class/crud.php");
require_once(dirname(__FILE__)."/../inc/class/cliente.php");
require_once(dirname(__FILE__)."/../inc/class/direccion.php");
include_once(dirname(__FILE__)."/../inc/funciones.inc.php");
//Instanciamos un obj de clase Crud...
//
$crud = new Crud();
//Instanciamos un obj de clase usuario...
//
$cliente = new Cliente();
//Instanciamos un obj de clase Dirección por cada dirección con la que trabajaremos...
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
        //La acción FILTRAR es la encargada de transmitir los datos para la estructuración del listado del aparatado listado...
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
            //Devolvemos un Json con todos los datos de los usuarios que debemos mostrar según el offset , limit y char pasados anteriormente...
            //
            echo($json_respuesta);
        }
        //La acción MOSTRAR es la encargada de otorgar los datos del usuario correspondiente en la vista para editar...
        //
        elseif($accion == "MOSTRAR")
        {
            //En el caso de que no llegue información del id del usuario desde la vista encargada de recoger los valores del mismo para mostrarlos este será 0 ,
            //en este caso devolveremos un mensaje de error...
            if($id == 0)
            {
                $r = array("respuesta"=>"No llega información del id...");
                $json_datos = json_encode($r);
                echo($json_datos);
            }
            else
            {
                //Obtenemos la información del usuario mediante los métodos de la clase crud obtener_us y obtener_direccion...
                //
                $cliente = $crud->obtener_us($id);
                $dom_fis = $crud->obtener_direccion($id , 1);
                $dom_soc = $crud->obtener_direccion($id , 2);
                //Metemos los datos recogidos en un array de keys y lo parseamos a formato Json para devolverlos a la vista y mostrarlos...
                //
                $r = array("usuario"=>$cliente , "dom_fis"=>$dom_fis , "dom_soc"=>$dom_soc);
                $json_datos = json_encode($r);
                echo($json_datos);
            }
        }
        //ELIMINAR elimina el usuario seleccionado...
        //
        elseif($accion == "ELIMINAR")
        {
            //Ejecutamos la eliminación del usuario mediante el método eliminar de la clase crud y recogemos la respuesta...
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
            $respuesta = "Alguno de los datos personales del usuario está vacío , reviselos...";
            $r = array("respuesta"=>$respuesta);
            $json_respuesta = json_encode($r);
            echo($json_respuesta);
            }
            //Validamos que los datos de la dirección fiscal considerados obligatorios para la gestión del usuario no estén vacíos ...
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
                $respuesta = "Alguno de los datos obligatorios de la dirección fiscal está vacío , reviselos..."; 
                $r = array("respuesta"=>$respuesta);
                $json_respuesta = json_encode($r);
                echo($json_respuesta);
            }
            else
            //No es necesario validar la dirección social puesto que es opcional...
            //
            {       
                //Creamos el objeto cliente con los datos del json...
                //
                $cliente->setDni( $datos['dni'] );  
                $cliente->setNombre( ucfirst($datos['nombre'] ));  
                $cliente->setPrimer_apellido( ucfirst($datos['primer_apellido'] ));
                $cliente->setSegundo_apellido( ucfirst($datos['segundo_apellido'] ));
                $cliente->setSexo( $datos['sexo'] );
                $cliente->setFecha_nacimiento( $datos['fecha_nacimiento'] );
                $cliente->setEstado_civil( $datos['estado_civil'] );
                $cliente->setEmail( $datos['email'] );
                $cliente->setTelefono( $datos['tlf'] );
                //Creamos la dirección social...
                //
                $direccion->setTipo_via( $datos['tipo_via'] );
                $direccion->setDireccion( $datos['direccion'] );
                $direccion->setComp_direccion( $datos['comp_direccion'] );
                $direccion->setNumero( $datos['numero'] );
                $direccion->setPiso( $datos['piso'] );
                $direccion->setPuerta( $datos['puerta'] );
                $direccion->setEscalera(  $datos['escalera'] );
                $direccion->setCod_postal(  $datos['cod_postal'] );
                $direccion->setLocalidad( ucfirst($datos['localidad'] ));
                $direccion->setProvincia( ucfirst($datos['provincia'] ));
                $direccion->setPais( ucfirst($datos['pais'] ));
                //Creamos la dirección fiscal...
                //       
                $direccion_2->setTipo_via( $datos['tipo_via_2'] );
                $direccion_2->setDireccion( $datos['direccion_2'] );
                $direccion_2->setComp_direccion( $datos['comp_direccion_2'] );
                $direccion_2->setNumero( $datos['numero_2'] );
                $direccion_2->setPiso( $datos['piso_2'] );
                $direccion_2->setPuerta( $datos['puerta_2'] );
                $direccion_2->setEscalera(  $datos['escalera_2'] );
                $direccion_2->setCod_postal(  $datos['cod_postal_2'] );
                $direccion_2->setLocalidad( ucfirst($datos['localidad_2'] ));
                $direccion_2->setProvincia( ucfirst($datos['provincia_2'] ));
                $direccion_2->setPais( ucfirst($datos['pais_2']));  
                //En el caso de que la acción a ejecutar sea AÑADIR se añade un nuevo usuario...
                //  
                if($accion == "AÑADIR")
                {
                    //Añadimos el nuevo usuario con el metodo insertar de la clase crud y recogemos la respuesta...
                    //
                    $respuesta = $crud->insertar( $cliente , $direccion , $direccion_2 );
                    $r = array("respuesta" => $respuesta);
                    //Parseamos la respuesta y la enviamos a la vista...
                    //
                    $json_respuesta = json_encode($r);
                    echo($json_respuesta);
                }
                //En el caso de que la acción a ejecutar sea EDITAR se edita el usuario...
                //
                elseif($accion == "EDITAR")
                { 
                    //Validamos que el id del usuario editar haya llegado correctamente...
                    //
                    if($id == 0)
                    {
                        $r = array("respuesta" => "No llega información del id del usuario");
                        $json_respuesta = json_encode($r);
                        echo($json_respuesta);
                    }
                    else
                    {
                        //Editamos el usuario con el motodo editar de la clase crud y recojemos la respuesta...
                        //
                        if($crud->editar( $cliente , $id , $direccion , $direccion_2 ) == true)
                        {
                            $respuesta = "Usuario modificado con éxito";   
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