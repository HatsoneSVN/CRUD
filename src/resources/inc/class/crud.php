<?php
//Iniciamos sesion...
//
session_start();
require_once(dirname(__FILE__)."/../../../database/conexion.inc.php");
include_once(dirname(__FILE__)."/../funciones.inc.php");
    class Crud
    {
        //constructor de la clase crud...
        //
        public function __construct(){}
        // método para insertar, recibe como parámetro los objetos usuario y direcciones...
        //
        public function insertar($cliente , $direccion , $direccion_2 )
        {       
            $db=Db::conectar();
            //Con esta sentencia preparamos la inserción de nuevos datos en los campos especificados de la tabla usuarios...
            //
            $insert=$db->prepare('INSERT INTO REGISTRO.CLIENTES 
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
            //de objeto en el controlador)...
            //
            $insert->bindValue('dni' , $cliente->getDni());
            $insert->bindValue('nombre',$cliente->getNombre());
            $insert->bindValue('primer_apellido',$cliente->getPrimer_apellido());
            $insert->bindValue('segundo_apellido',$cliente->getSegundo_apellido());
            $insert->bindValue('fecha_nacimiento',$cliente->getFecha_nacimiento());
            $insert->bindValue('sexo',$cliente->getSexo());
            $insert->bindValue('estado_civil',$cliente->getEstado_civil());
            $insert->bindValue('email',$cliente->getEmail());
            $insert->bindValue('tlf',$cliente->getTelefono());
            //Recogemos la exception que salta en el caso de introducir un valor único por duplicado y personalizamos el mensaje...
            // 
            try
            {
                $insert->execute();
                $dni = $cliente->getDni();
                $select = $db->query("SELECT id_us FROM REGISTRO.CLIENTES WHERE dni = '$dni'");
                $id_us = $select->fetch();
                $id = $id_us['id_us'];  
                $tipo_direccion = 1;
                //Llamada a la función para insertar la residencia habitual(obligatoria)...
                //    
                if($insert == true)
                {                  
                    if( insert_direccion($db , $direccion , $id , $tipo_direccion) == true )
                    {
                        //Creamos el domicilio social(opcional)...
                        //
                        $tipo_direccion = 2; 
                        if( insert_direccion($db , $direccion_2 , $id , $tipo_direccion) == true )
                        {
                            return "Usuario se ha añadido correctamente";
                        }
                        else
                        {
                            return "Error al añadir el domicilio social";
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
                            return "El DNI , teléfono o email introducido ya existe , revíselo...";
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
                $select=$db->query("SELECT * FROM REGISTRO.CLIENTES LIMIT $limit OFFSET $offset");
                $todas = true; 
            }
            else
            {
                $select=$db->query("SELECT * FROM REGISTRO.CLIENTES 
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
			foreach($select->fetchAll() as $cliente){
                $nuevoUsuario= new Cliente();             
                $nuevoUsuario->setId($cliente['id_us']);             
                $nuevoUsuario->setDni($cliente['dni']);             
                $nuevoUsuario->setNombre($cliente['nombre']);               
                $nuevoUsuario->setPrimer_apellido($cliente['primer_apellido']);
                $nuevoUsuario->setSegundo_apellido($cliente['segundo_apellido']);
                $nuevoUsuario->setEmail($cliente['email']);
                $nuevoUsuario->setTelefono($cliente['tlf']);
                $nuevoUsuario->RowsTotal($bus_char);
                //En el array instanciado anteriormente guardamos cada nuevo objeto de tipo usuario...
                //
				$lista_usuarios [] = $nuevoUsuario;
            }
            //La función retorna un array que contiene todos los usuarios con sus atributos...
            //
            return $lista_usuarios;         
        }
        //Función que recoge los datos del usuario de la BD con el id pasado por parametro(
        // con la información instanciamos un objeto de tipo usuario con los atributos correspondientes)....
        //
        public function obtener_us( $id )
        {
            //Instanciamos los objetos que nos servirán para rellenar los valores del form de editar...
            //
            $nuevoUsuario= new Cliente();
            $db=Db::conectar();
            $select=$db->prepare('SELECT * FROM REGISTRO.CLIENTES WHERE id_us=:id');
			$select->bindValue('id',$id);
			$select->execute();
            //fetch recoge la fila de valores de un conjunto de resultados en forma de array...
            //
			$cliente=$select->fetch();
            $nuevoUsuario->setId($cliente['id']);               
            $nuevoUsuario->setDni($cliente['dni']);         
            $nuevoUsuario->setNombre($cliente['nombre']);      
            $nuevoUsuario->setPrimer_apellido($cliente['primer_apellido']);
            $nuevoUsuario->setSegundo_apellido($cliente['segundo_apellido']);
            $nuevoUsuario->setSexo($cliente['sexo']);
            $nuevoUsuario->setFecha_nacimiento($cliente['fecha_nacimiento']);
            $nuevoUsuario->setEstado_civil($cliente['estado_civil']);
            $nuevoUsuario->setEmail($cliente['email']);
            $nuevoUsuario->setTelefono($cliente['tlf']);
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
        public function editar($cliente , $id , $direccion , $direccion_2)
        {
            $db=Db::conectar();
            //Funciona de la misma manera que la funcón insert...
            //
            $editar=$db->prepare('UPDATE REGISTRO.CLIENTES     
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
            $editar->bindValue('dni',$cliente->getDni());     
            $editar->bindValue('nombre',$cliente->getNombre());           
            $editar->bindValue('primer_apellido',$cliente->getPrimer_apellido());
            $editar->bindValue('segundo_apellido',$cliente->getSegundo_apellido());
            $editar->bindValue('fecha_nacimiento',$cliente->getFecha_nacimiento());
            $editar->bindValue('sexo',$cliente->getSexo());
            $editar->bindValue('estado_civil',$cliente->getEstado_civil());
            $editar->bindValue('email',$cliente->getEmail());
            $editar->bindValue('tlf',$cliente->getTelefono());
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
                            return "Error al editar la dirección social del usuario";
                        }                  
                    }
                    else
                    {
                        return "Error al editar la dirección fiscal del usuario";
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
                $eliminar=$db->query("DELETE FROM REGISTRO.CLIENTES WHERE id_us='$id'");
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
        //Esta función comprueba al logearse si el usuario existe...
        //
        public function comp_login($nom_email , $pass)
        {
            $db=DB::conectar();
            $select = $db->query("SELECT id, pass , nombre , email , fecha_creacion , fecha_modificacion FROM REGISTRO.USUARIOS WHERE email LIKE '$nom_email' OR nombre LIKE '$nom_email'");
            $row_affect = $select->rowCount();
            if($row_affect == 0)
            {
                return "El nombre de usuario introducido o email no existe...";
            }
            else
            {
                //Extraemos los datos del usuario...
                //
                $datos = $select->fetch();
                $id = $datos['id'];
                $pass_us = $datos['pass'];
                $nombre = $datos['nombre'];
                $email = $datos['email'];
                $afiliacion = $datos['fecha_afiliacion'];
                $modificacion = $datos['fecha_modificacion'];;
                //Verificamos si la contraseña es correcta(la contraseña esta hasheada , uilizamos el metodo password_verify)
                //
                if(password_verify($pass , $pass_us))
                {
                    //En el caso de que todos los parámetros sean correctos creamos varibles de sesion con los datos siguientes...
                    //
                    $_SESSION['PASS'] = $pass_us;//ojo contraseña esta en formato hash...
                    $_SESSION['ID'] = $id;
                    $_SESSION['LOGGED'] = true;
                    $_SESSION['NOMBRE'] = $nombre;
                    $_SESSION['EMAIL'] = $email;
                    $_SESSION['AFILIACION'] = $afiliacion;
                    $_SESSION['MODIFICACION'] = $modificacion;
                    $usuario = new Usuario($email , $nombre , "");
                    $respuesta = array("respuesta"=>"OK" , "usuario"=>$usuario);
                    return $respuesta;
                }
                else
                {
                    //En el caso de que los parámetros no sean correctos destruimos la session y enviamos el mensaje de error...
                    //
                    session_destroy();
                    return "La contraseña introducida no es correcta";
                }
            }
        }
        //Este metodo registra los usuarios...
        //
        public function register($usuario)
        {
            $db=Db::conectar();
            $insert=$db->prepare('INSERT INTO REGISTRO.USUARIOS 
            ( 
            email,
            nombre , 
            pass
            )            
            values(
            :email,
            :nombre,
            :pass)');      
            //
            //
            $insert->bindValue('email' , $usuario->email);
            $insert->bindValue('nombre',$usuario->nombre);
            $insert->bindValue('pass',$usuario->pass);
            try
            {
                $insert->execute();
                if($insert == true)
                {
                    //En el caso de que todos los parámetros sean correctos...
                    //
                    return "OK";
                }
                else
                {
                    //En caso de error...
                    //
                    session_destroy();
                    return "Error al crear el usuario...";
                }
            }
            //Capturamos la exception que nos da mysql al duplicar valores únicos y enviamos un mensaje de error...
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
                            return "El usuario ya existe...";
                        }
                    default:
                        return $e->getMessage();
                }
            }
        }
        //Esta función destruye la session y devuelve OK...
        //
        public function exit()
        {
            session_destroy();
            return "OK";
        }
        //Esta fucnión modifica los datos no sensibles del usuario...
        //
        public function upd_us($usuario)
        {
            $db=Db::conectar();
            $editar=$db->prepare('UPDATE REGISTRO.USUARIOS     
            SET email=:email , 
            nombre=:nombre 
            WHERE id=:id');
            $editar->bindValue('id' , $_SESSION['ID'] );   
            $editar->bindValue('email',$usuario->email);     
            $editar->bindValue('nombre',$usuario->nombre);           
            try{
            $editar->execute();
                if ( $editar == true )
                {
                    $_SESSION['NOMBRE'] = $usuario->nombre;
                    $_SESSION['EMAIL'] = $usuario->email;
                    return "Las modificaciones se han llevado a cabo con exito";
                }
                else
                {
                    return "Error al modificar los datos del usuario...";
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
                            return "El Nick o email introducidos ya existen..."; 
                        }
                    default:
                        return $e->getMessage();
                }
            }
        }
        //Esta fucnión modifica la contraseña del us...
        //
        public function upd_pass($pass , $usuario)
        {
            if(password_verify($pass, $_SESSION['PASS'] ))
            {
                $db=Db::conectar();
                $editar=$db->prepare('UPDATE REGISTRO.USUARIOS     
                SET pass=:pass  
                WHERE id=:id');
                $editar->bindValue('id' , $_SESSION['ID'] );   
                $editar->bindValue('pass',$usuario->pass);   
                $_SESSION['PASS'] = $usuario->pass;  
                return "Contraseña modificada correctamente";
            }else
            {
                return "La contraseña antigua introducida no es correcta...";
            }
        }
    }
?>