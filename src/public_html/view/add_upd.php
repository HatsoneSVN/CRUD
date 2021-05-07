<?php
require_once(dirname(__FILE__)."/../../resources/inc/html/header.php");  
require_once(dirname(__FILE__)."/../../resources/inc/html/menu.php");
//Recogenos la acción que nos envía la vista anterior y la validamos...
//
if(!isset($_GET['accion']))
{
	$accion = false;
}
elseif(empty($_GET['accion']))
{
	$accion = false;
}
else
{
	//Recogenos la accion y el id del usuario sobre el que se ejecutara(en el caso de que exista)...
	//
	$accion = $_GET['accion'];
	$id = @$_GET['id'];
    if(!isset($id))
    {
		$id = 0;
	}
	elseif(empty($id)) 
	{
		$id = 0;
	}
}

?>
		<contenido>
			<form action="/../../resources/controller/controlador.php" method="post" name="form_datos_personales" id="form_datos_personales" enctype="multipart/form-data">
					<input type="hidden" name="id" id="id" value = <?php echo($id)?>>
					<input type="hidden" name="accion" id="accion" value=<?php echo($accion)?>>
				<div id="identificacion">
						<div class="cabecera">
							<h2>Identificacion*</h2>
						</div>
							<div class=barra_dato>
								Nombre Usuario*:<br>
								<input type="text" name="nombre" id="nombre" maxlength="30" required placeholder=" Jose...">
							</div>	
							<div class=barra_dato>
								Primer apellido*:<br>
								<input type="text" name="primer_apellido" id="primer_apellido" maxlength="30"  required placeholder=" Suarez...">
							</div>	
							<div class=barra_dato>
								Segundo apellido*:<br>
								<input type="text" name="segundo_apellido" id="segundo_apellido" maxlength="30"  required placeholder=" Fernandez...">
							</div>
							<div class=barra_dato>
								DNI Usuario*:<br>
								<input type="text" name="dni" id="dni" maxlength="9"  required placeholder=" 70408202G...">
							</div>
							<div class=barra_dato>
								Sexo*:<br>
								<select name="sexo" id="sexo"  required>
									<option value="hombre">Hombre</option>
									<option value="mujer">Mujer</option>
								</select>
							</div>
							<div class=barra_dato>
								Fecha de nacimiento*:<br>
								<input type="date" name="fecha_nacimiento" id="fecha_nacimiento"  required>
							</div>	
							<div class=barra_dato>
								Estado civil*:<br>
								<select name="estado_civil" id="estado_civil" required>
									<option value="casado">Casado</option>
									<option value="soltero">Soltero</option>
									<option value="divorciado">Divorciado</option>
									<option value="viudo">Viudo</option>
								</select>
							</div>
							<div class=barra_dato>
								E-mail*:<br>
								<input type="email" name="email" id="email"  maxlength="80" required placeholder=" example-2803@gmail.com">
							</div>
							<div class=barra_dato>
								Teléfono*:<br>
								<input type="tel" name="tlf" id="tlf" maxlength="9" required placeholder=" 666555444...">
							</div>		
					<!--Formualario datos direccion_fiscal-->
						<div class="cabecera">
							<h2>Domicilio Fiscal*</h2>
						</div>
						<div class="barra_dato">
							Via:<br>
							<select name="tipo_via" id="tipo_via" required >
								<option value="" placeholder=" C/ , avd..."></option>
								<option value="plaza">C/</option>
								<option value="avenida">avd.</option>
								<option value="plaza">plza.</option>
								<option value="apartamento">apto.</option>
								<option value="atico">at.</option>
								<option value="bajo">bj.</option>
								<option value="carretera">Ctra</option>
								<option value="travesia">tr.ª</option>
								<option value="urbanizacion">urb.</option>
							</select> 
						</div>
						<div class="barra_dato">
							Nombre via*:<br>
							<input type="text" name="direccion" id="direccion"  maxlength="60" required placeholder=" Alcalá..">
						</div>
						<div class="barra_dato">
							Complemeto via:<br>
							<input type="text" name="comp_direccion" id="comp_direccion"  maxlength="30" placeholder=" Polígono , Urbanización...">
						</div>
						<div class="barra_dato">
							Número*:<br>
								<input type="text" name="numero" id="numero"  maxlength="3" required placeholder=" 2... " >
						</div>
						<div class="barra_dato">
							Escalera:<br> 
								<input type="text" name="escalera" id="escalera"  maxlength="10" placeholder=" derecha...">
						</div>
						<div class="barra_dato">
							Piso*:<br>
								<input type="text" name="piso" id="piso" maxlength="4" required placeholder=" bajo , 1 , 2...">
						</div>
						<div class="barra_dato">
							Puerta:<br>
								<input type="text" name="puerta" id="puerta" maxlength="10" placeholder="A , B , Izquierda...">
						</div>
						<div class="barra_dato">
							Cod_Postal*:<br>
								<input type="text" name="cod_postal" id="cod_postal" minlenght="4" maxlength="8" required placeholder=" 24400...">
						</div>
						<div class="barra_dato">
							Localidad*:<br>
								<input type="text" name="localidad" id="localidad"   maxlength="60"  required placeholder=" Leon , Ponferrada...">
						</div>
						<div class="barra_dato">
							Provincia*:<br>
								<input type="text" name="provincia" id="provincia" maxlength="30" required placeholder=" Leon , Aturias...">
						</div>
						<div class="barra_dato">
							País*:<br>
								<input type="text" name="pais" id="pais"  maxlength="60" required placeholder=" España , Francia...">
						</div>
					<!--Datos para la direccion social-->
					<div id="res_2">
						<div class="cabecera">
							<h2>Domicilio Social</h2> 
						</div>
						<div class="barra_dato">
							Via:<br>
							<select name="tipo_via_2" id="tipo_via_2">
								<option value="" placeholder=" C/ , avd..."></option>
								<option value="plaza">C/</option>
								<option value="avenida">avd.</option>
								<option value="plaza">plza.</option>
								<option value="apartamento">apto.</option>
								<option value="atico">at.</option>
								<option value="bajo">bj.</option>
								<option value="carretera">Ctra</option>
								<option value="travesia">tr.ª</option>
								<option value="urbanizacion">urb.</option>
							</select> 
						</div>
						<div class="barra_dato">
							Nombre via:<br>
								<input type="text" name="direccion_2" id="direccion_2" maxlength="60" placeholder=" Alcalá..">
						</div>
						<div class="barra_dato">
							Complemeto via:<br>
							<input type="text" name="comp_direccion_2" id="comp_direccion_2" maxlength="30"  placeholder=" Polígono , Urbanización...">
						</div>
						<div class="barra_dato">
							Número:<br>
							<input type="text" name="numero_2" id="numero_2"   maxlength="3"  placeholder=" 2... " >
						</div>
						<div class="barra_dato">
							Escalera:<br>
								<input type="text" name="escalera_2" id="escalera_2" maxlength="10" placeholder=" derecha...">
						</div>
						<div class="barra_dato">
							Piso:<br>
								<input type="text" name="piso_2" id="piso_2"  maxlength="4" placeholder=" bajo , 1 , 2..." >
						</div>
						<div class="barra_dato">
							Puerta:<br>
								<input type="text" name="puerta_2" id="puerta_2" maxlength="10" placeholder="A , B , Izquierda...">
						</div>
						<div class="barra_dato">
							Cod_Postal:<br>
								<input type="text" name="cod_postal_2" id="cod_postal_2"  minlenght="4" maxlength="8"  placeholder=" 24400...">
						</div>
						<div class="barra_dato">
							Localidad:<br>
								<input type="text" name="localidad_2" id="localidad_2"  maxlength="60" placeholder=" Leon , Ponferrada...">
						</div>
						<div class="barra_dato">
							Provincia:<br>
								<input type="text" name="provincia_2" id="provincia_2"  maxlength="30" placeholder=" Leon , Aturias...">
						</div>
						<div class="barra_dato">
							País:<br>
								<input type="text" name="pais_2" id="pais_2" maxlength="60" placeholder=" España , Francia...">
						</div> 			
					</div>
				</div>
			</form>
			<div id="boton_env">
				<button type="button" id="guardar" >Guardar</button>
			</div>	
		</contenido>
		<script src="../js/rules_val.js"></script>
		<script src="../js/add_cont.js"></script>
		<script src="../js/add_upd.js"></script>
	</body>
</html>
