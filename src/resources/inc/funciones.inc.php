<?php
//Esta función se encarga de insertar las direcciones en la BD...
//
function insert_direccion($db , $direccion , $id , $tipo_direccion)
{
	//Sentencia SQL para insertar una nueva dirección con los parametros que le pasamos por parametro...
	//
	$insert=$db->prepare('INSERT INTO REGISTRO.DIRECCIONES 
		( 
		tipo_via,
		direccion , 
		numero , 
		escalera , 
		piso, 
		puerta, 
		cod_postal,
		localidad, 
		provincia,
		pais,
		id_us,
		tipo_direccion,
		comp_direccion
		)            
		values(
		:tipo_via,
		:direccion,
		:numero,
		:escalera,
		:piso,
		:puerta,
		:cod_postal,
		:localidad,
		:provincia,
		:pais,
		:id_us,
		:tipo_direccion,
		:comp_direccion
		)');	
		$insert->bindValue('tipo_via',$direccion->getTipo_via());   
		$insert->bindValue('direccion',$direccion->getDireccion());
		$insert->bindValue('numero',$direccion->getNumero());
		$insert->bindValue('escalera',$direccion->getEscalera());
		$insert->bindValue('piso',$direccion->getPiso());
		$insert->bindValue('puerta',$direccion->getPuerta());
		$insert->bindValue('cod_postal',$direccion->getCod_postal());
		$insert->bindValue('localidad',$direccion->getLocalidad());
		$insert->bindValue('provincia',$direccion->getProvincia());
		$insert->bindValue('pais',$direccion->getPais());
		$insert->bindValue('id_us',$id);
		$insert->bindValue('tipo_direccion',$tipo_direccion);
		$insert->bindValue('comp_direccion',$direccion->getComp_direccion());
	$insert->execute();
	return $insert;
}
//Esta función se encatga de editar direcciones en la BD...
//
function update_direccion($db , $direccion , $id , $tipo_direccion)
{
	//primero comprobamos si la dirección existe...
	//
	$select=$db->query("SELECT * FROM REGISTRO.DIRECCIONES WHERE id_us ='$id' AND tipo_direccion='$tipo_direccion'");
		$rows = $select->rowCount();
	//en el caso de que la dirección no exista llamamos a la función  insert_direccion para hacer la nueva inserción...
	//
	if($rows == 0)
	{
		$editar = insert_direccion($db , $direccion , $id , $tipo_direccion);
	}
	//En el caso de que la dirección exista la editamos...
	//
	else
	{
		$editar=$db->prepare('UPDATE REGISTRO.DIRECCIONES 
		SET 
		tipo_via = :tipo_via,
		direccion = :direccion, 
		numero = :numero, 
		escalera = :escalera, 
		piso = :piso, 
		puerta = :puerta, 
		cod_postal = :cod_postal,
		localidad = :localidad, 
		provincia = :provincia,
		pais = :pais,
		comp_direccion = :comp_direccion
		WHERE id_us=:id AND tipo_direccion = :tipo_direccion');
		$editar->bindValue('tipo_via',$direccion->getTipo_via());   
		$editar->bindValue('direccion',$direccion->getDireccion());
		$editar->bindValue('numero',$direccion->getNumero());
		$editar->bindValue('escalera',$direccion->getEscalera());
		$editar->bindValue('piso',$direccion->getPiso());
		$editar->bindValue('puerta',$direccion->getPuerta());
		$editar->bindValue('cod_postal',$direccion->getCod_postal());
		$editar->bindValue('localidad',$direccion->getLocalidad());
		$editar->bindValue('provincia',$direccion->getProvincia());
		$editar->bindValue('pais',$direccion->getPais());
		$editar->bindValue('id',$id);
		$editar->bindValue('tipo_direccion',$tipo_direccion);
		$editar->bindValue('comp_direccion',$direccion->getComp_direccion());
		$editar->execute();
	}
	return $editar;
}
//Esta función separa las fechas de las horas y las ordena...
//
function separar_ordenar_fechas( $fecha )
{
	$contiene_hora =  strpos( $fecha , ":" );
	if( $contiene_hora == false )
	{
		$fecha_separada = explode( "-" , $fecha );
			$dia = $fecha_separada[2];
			$mes = $fecha_separada[1];
			$año = $fecha_separada[0];
		$fecha_ordenada = $dia . "-" . $mes  . "-" . $año;
	}
	else
	{
		//
		//separamos la fecha de la hora y la ordenamos
		$fecha_hora = explode( " " , $fecha );
		$fecha_conjunto = $fecha_hora[0];
		$fecha_separada = explode( "-" , $fecha_conjunto );
			$dia = $fecha_separada[2];
			$mes = $fecha_separada[1];
			$año = $fecha_separada[0];
		$fecha_ordenada = $dia . "-" . $mes  . "-" . $año;
	}
	return $fecha_ordenada;
}

?>