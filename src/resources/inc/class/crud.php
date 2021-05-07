<?php

require_once(dirname(__FILE__)."/../../database/conexion.inc.php");
include_once(dirname(__FILE__)."/../funciones.inc.php");
    class Crud
    {
        //constructor de la clase crud...
        //
        public function __construct(){}
        // método para insertar, recibe como parámetro los objetos usuario y direcciones...
        //
        public function insertar($usuario , $direccion , $direccion_2 )
        {       
            $db=Db::conectar();
            //Con esta sentencia preparamos la inserción de nuevos datos en los campos especificados de la tabla usuarios...
            //
            $insert=$db->prepare('INSERT INTO REGISTRO.USUARIOS 
            ( 
            dni ,
            nombre , 
            primer_apellido , 
            segundo_apellido , 
            fecha_nacimiento, 
            sexo, 
            estado_civil,
            email, 
            tlf  
            )            
            values(
            :dni,
            :nombre,
            :primer_apellido,
            :segundo_apellido,
            :fecha_nacimiento,
            :sexo,
            :estado_civil,
            :email,
            :tlf
             )');      
            //Cada sentencia insert insertará cada valor en su correspondiente campo( los valores provienen de una instancia 
            //de objeto en el controlador...
            //
            $insert->bindValue('dni' , $usuario->getDni());
            $insert->bindValue('nombre',$usuario->getNombre());
            $insert->bindValue('primer_apellido',$usuario->getPrimer_apellido());
            $insert->bindValue('segundo_apellido',$usuario->getSegundo_apellido());
            $insert->bindValue('fecha_nacimiento',$usuario->getFecha_nacimiento());
            $insert->bindValue('sexo',$usuario->getSexo());
            $insert->bindValue('estado_civil',$usuario->getEstado_civil());
            $insert->bindValue('email',$usuario->getEmail());
            $insert->bindValue('tlf',$usuario->getTelefono());
            //Recogemos la exception que salta en el caso de introducir un valor único por duplicado y personalizamos el mensaje...
            // 
            try
            {
                $insert->execute();
                $dni = $usuario->getDni();
                $select = $db->query("SELECT id_us FROM REGISTRO.USUARIOS WHERE dni = '$dni'");
                $id_us = $select->fetch();
                $id = $id_us['id_us'];  
                $tipo_direccion = 1;
                //Llamada a la función para insertar la residencia habitual(obligatoria)...
                //    
                if($insert == true)
                {                  
                    if( insert_direccion($db , $direccion , $id , $tipo_direccion) == true )
                    {
                        //Si la direccion 2 es false no crearemos domicilio social...
                        //
                        if($direccion_2 != false)
                        {
                            $tipo_direccion = 2;
                            
                            if( insert_direccion($db , $direccion_2 , $id , $tipo_direccion) == true )
                            {
                                return "El usuario se ha añadido correctamente";
                            }
                            else
                            {
                                return "Error al añadir el domicilio social";
                            }
                        }
                        else
                        {
                            return "El usuario se añadido correctamente";
                        } 
                    }
                    else
                    {
                    return "Error al añadir el domicilio fiscal";
                    }
                }
                else
                {
                    return "Error al introducir el usuario";
                }
               
            }
            //Capturamos la exception que se produce al introducir un campo considerado único duplicado y lo devolvemos como resultado negativo...
            //
            catch(Exception $e)
            {
                switch ($e->getCode()) 
                {
                    case 23000:
                        $error_ejecutado= $e->getMessage();
                        $error_dividido= explode(" ", $error_ejecutado);
                        if (in_array("1062",$error_dividido))
                        {
                            return "El DNI , teléfono o email introducido ya existe , revíselo";
                        }
                    default:
                        return $e->getMessage();
                }
            }

        } 
        //Metodo para mostrar los datos de la BD...
        //
        public function mostrar($bus_char , $offset , $limit)
        {
            //Conectamos con la base de datos..
            //
            $db=Db::conectar();      
            //Instanciamos un array...
            //
            $lista_usuarios=[];
            //Creamos la sentencia que extrae los registros de la base de datos...
            //
            if(empty($bus_char))
            {
                $select=$db->query("SELECT * FROM REGISTRO.USUARIOS LIMIT $limit OFFSET $offset");
                $todas = true; 
            }
            else
            {
                $select=$db->query("SELECT * FROM REGISTRO.USUARIOS 
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
                tlf LIKE '%$bus_char%' 
                LIMIT $limit OFFSET $offset
                ");
            }      
            //Con este bucle instanciamos un obj por cada fila de la bd con la información que almacena( por cada usuario )...
            //
			foreach($select->fetchAll() as $usuario){
                $nuevoUsuario= new Usuario();             
                $nuevoUsuario->setId($usuario['id_us']);             
                $nuevoUsuario->setDni($usuario['dni']);             
                $nuevoUsuario->setNombre($usuario['nombre']);               
                $nuevoUsuario->setPrimer_apellido($usuario['primer_apellido']);
                $nuevoUsuario->setSegundo_apellido($usuario['segundo_apellido']);
                $nuevoUsuario->setEmail($usuario['email']);
                $nuevoUsuario->setTelefono($usuario['tlf']);
                $nuevoUsuario->RowsTotal($bus_char);
                //En el array instanciado anteriormente guardamos cada nuevo objeto de tipo usuario...
                //
				$lista_usuarios [] = $nuevoUsuario;
            }
            //La funciÓn retorna un array que contiene todos los usuarios con sus atributos...
            //
            return $lista_usuarios;
           // $lista_usuarios;          
        }
        //Función que recoge los datos del usuario de la BD con el id pasado por parametro(
        // con la información instanciamos un objeto de tipo usuario con los atributos correspondientes)....
        //
        public function obtener_us( $id )
        {
            //Instanciamos los objetos que nos servirán para rellenar los valores del form de editar...
            //
            $nuevoUsuario= new Usuario();
            $db=Db::conectar();
            $select=$db->prepare('SELECT * FROM REGISTRO.USUARIOS WHERE id_us=:id');
			$select->bindValue('id',$id);
			$select->execute();
            //fetch recoge la fila de valores de un conjunto de resultados en forma de array...
            //
			$usuario=$select->fetch();
            $nuevoUsuario->setId($usuario['id']);               
            $nuevoUsuario->setDni($usuario['dni']);         
            $nuevoUsuario->setNombre($usuario['nombre']);      
            $nuevoUsuario->setPrimer_apellido($usuario['primer_apellido']);
            $nuevoUsuario->setSegundo_apellido($usuario['segundo_apellido']);
            $nuevoUsuario->setSexo($usuario['sexo']);
            $nuevoUsuario->setFecha_nacimiento($usuario['fecha_nacimiento']);
            $nuevoUsuario->setEstado_civil($usuario['estado_civil']);
            $nuevoUsuario->setEmail($usuario['email']);
            $nuevoUsuario->setTelefono($usuario['tlf']);
            return $nuevoUsuario;
        }
        //Igual que la función anterior pero con la dirección...
        //
        function obtener_direccion($id , $tipo_direccion)
        {
            $db=Db::conectar();
            $select=$db->query("SELECT * FROM REGISTRO.DIRECCIONES WHERE id_us='$id' AND tipo_direccion = '$tipo_direccion'");
            $col_afect = $select->rowCount();
            $nuevaDireccion= new Direccion();    
            if( $col_afect > 0 )
            {
               $direccion = $select->fetch();
                    $nuevaDireccion->setTipo_via($direccion['tipo_via']);   
                    $nuevaDireccion->setDireccion($direccion['direccion']);
                    $nuevaDireccion->setNumero($direccion['numero']);
                    $nuevaDireccion->setEscalera($direccion['escalera']);
                    $nuevaDireccion->setPiso($direccion['piso']);
                    $nuevaDireccion->setPuerta($direccion['puerta']);
                    $nuevaDireccion->setCod_postal($direccion['cod_postal']);
                    $nuevaDireccion->setLocalidad($direccion['localidad']);
                    $nuevaDireccion->setProvincia($direccion['provincia']);
                    $nuevaDireccion->setPais($direccion['pais']);
                    $nuevaDireccion->setComp_direccion($direccion['comp_direccion']);                    
            }       
            return $nuevaDireccion;  
        }
        // método para editar un usuario, recibe como parámetros el obj usuario con su id y direcciones correspondientes...
        //
        public function editar($usuario , $id , $direccion , $direccion_2)
        {
            $db=Db::conectar();
            //Funciona de la misma manera que la funcion insert...
            //
            $editar=$db->prepare('UPDATE REGISTRO.USUARIOS     
            SET dni=:dni , 
            nombre=:nombre ,
            primer_apellido=:primer_apellido,
            segundo_apellido=:segundo_apellido,
            fecha_nacimiento=:fecha_nacimiento,
            sexo=:sexo,
            estado_civil=:estado_civil,
            email=:email,
            tlf=:tlf
            WHERE id_us=:id');
            $editar->bindValue('id' , $id );   
            $editar->bindValue('dni',$usuario->getDni());     
            $editar->bindValue('nombre',$usuario->getNombre());           
            $editar->bindValue('primer_apellido',$usuario->getPrimer_apellido());
            $editar->bindValue('segundo_apellido',$usuario->getSegundo_apellido());
            $editar->bindValue('fecha_nacimiento',$usuario->getFecha_nacimiento());
            $editar->bindValue('sexo',$usuario->getSexo());
            $editar->bindValue('estado_civil',$usuario->getEstado_civil());
            $editar->bindValue('email',$usuario->getEmail());
            $editar->bindValue('tlf',$usuario->getTelefono());
            try{
            $editar->execute();
                if ( $editar == true )
                {
                    $tipo_direccion = 1;           
                    if( update_direccion($db , $direccion , $id , $tipo_direccion) == true )
                    {
                        $tipo_direccion = 2;                   
                        if( update_direccion($db , $direccion_2 , $id , $tipo_direccion) == true )
                        {
                            return true;
                        }
                        else
                        {
                            return "Error al editar la direccion social del usuario";
                        }                  
                    }
                    else
                    {
                        return "Error al editar la direccion fiscal del usuario";
                    }    
                }
                else
                {
                    return "Error al editar el usuario" ;
                }
            } 
            catch(Exception $e)
            {
                switch ($e->getCode()) 
                {
                    case 23000:
                        $error_ejecutado= $e->getMessage();
                        $error_dividido= explode(" ", $error_ejecutado);
                        if (in_array("1062",$error_dividido))
                        {
                            return "El DNI , teléfono o email introducido ya existe , revíselo"; 
                        }
                    default:
                        return $e->getMessage();
                }
            }
        }
        //Metodo para eliminar el usuario elegido mediante el id...
        //       
        public function eliminar( $id )
        {
            $db=Db::conectar();
			$eliminar=$db->query("DELETE FROM REGISTRO.DIRECCIONES WHERE id_us='$id'");
            if($eliminar == true)
            {
                $eliminar=$db->query("DELETE FROM REGISTRO.USUARIOS WHERE id_us='$id'");
                if($eliminar == true)
                {
                    //En caso de ejecutarse la accion con exito devolverá OK...
                    //
                    return "OK";
                }
                else
                {
                    return "Error en la sentencia para eliminar el usuario";
                }
            }
            else
            {
                return "Error en la sentencia para eliminar las direcciones";
            }
        }  
    }
?>