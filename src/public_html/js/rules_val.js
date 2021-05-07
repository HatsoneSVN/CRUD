$( document ).ready( function() 
{
	//Metodo que detecta que el valor pasado por parametro no contenga ningún numero, devuelve true o false...
	//
	$.validator.addMethod("validar_solo_letras", function (valor) 
	{
		var numeros =["0" , "1" , "2" , "3" , "4" , "5" , "6" , "7" ,"8" ,"9" ,"10"];	
		for(var i = 0 ; i < numeros.length ; i++ )
		{
			var comp =  valor.indexOf(numeros[i]);
			if( comp == -1 )
			{			
				correcto = true;
			}
			else
			{
				i = numeros.length;
				correcto = false;
			}
		}
		return correcto;	
	  });
	//Metodo que valida el dni del usuario , devuelve true o false...
	//	
	$.validator.addMethod("validar_dni", function(dni)
	{
		var letras = ['T' , 'R' , 'W' , 'A' , 'G' , 'M' , 'Y' , 'F' , 'P' , 'D' , 'X' , 'B' , 'N' , 'J' , 'Z' , 'S' , 'Q' , 'V' , 'H' , 'L' , 'C' , 'K' , 'E' ];
		var numero = dni.substr( 0 , 8 );
		var letra = dni.charAt(8);		
		var letra_may = letra.toLocaleUpperCase();
		var posicion_letra_correcta = numero % 23;
		var letra_correcta = letras[ posicion_letra_correcta ];	
		if( letra_may != letra_correcta )
		{
			return false;
		}
		else
		{
			return true;
		}
		});
    jQuery( function()
	{
		jQuery( "#form_datos_personales" ).validate({
			rules: {	
			//Validaciones para los datos personales...
			//
				nombre: {
					maxlength: 30,
					validar_solo_letras: true
				},
				primer_apellido: {
					maxlength: 30,
					validar_solo_letras: true
				},
				segundo_apellido: {
					maxlength: 30,
					validar_solo_letras: true
				},
				dni: {
					minlength: 9,
					maxlength: 9,
					validar_dni:true
				},
				email: {
					email:true
				},
				tlf:{
					minlength: 9,
					maxlength: 9,
					number:true
				},
			//Validaciones para los datos del domicilio fiscal...
			//
				direccion: {
					minlength:4,
					maxlength:60
				},
				comp_direccion:{
                    minlength: 4,
					maxlength:60,
					validar_solo_letras:true
                },
				numero: {
					number:true,
					min:0,
					//max:200
				},
				piso: {
					maxlength:4
				},
				puerta: {
					validar_solo_letras:true
				},
				escalera: {
					maxlength: 10
				},
				cod_postal: {
					number:true,
					min:1,
					minlength:4		
				},
				localidad: {
					maxlength:60,
					validar_solo_letras:true
				},
				provincia: {
					maxlength:30,
					validar_solo_letras:true
				},
				pais: {
					maxlength:60,
					validar_solo_letras:true
				},
			//Validaciones para domicilio social...
			//
			direccion_2: {
				minlength:4,
				maxlength:60
			},
			comp_direccion_2:{
				minlength: 4,
				maxlength:60,
				validar_solo_letras:true
			},
			numero_2: {
				number:true,
				min:0,
				//max:200
			},
			piso_2: {
				maxlength:4
			},
			puerta_2: {
				maxlength:10,
				validar_solo_letras:true
			},
			escalera_2: {
				maxlength: 10
			},
			cod_postal_2: {
				number:true,
				min:1,
				minlength:4		
			},
			localidad_2: {
				minlength: 1,
				maxlength:60,
				validar_solo_letras:true
			},
			provincia_2: {
				maxlength:30,
				validar_solo_letras:true
			},
			pais_2: {
				maxlength:60,
				validar_solo_letras:true
			},
		//Mensajes de error...
		//
		},
		messages: {
			//Mensajes de error para los datos personales...
			//
				nombre: {
						minlength: "Introduce al menos {0} caracteres",
						maxlength:"Maximo de {0} caracteres",
						validar_solo_letras: "No debe contener valores numéricos",
						required:"Rellene este campo"
				},
				primer_apellido: {
					maxlength:"Maximo de {0} caracteres",
					validar_solo_letras: "No debe contener valores numéricos",
					required:"Rellene este campo"
				},
				segundo_apellido: {
					maxlength:"Maximo de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",
					required:"Rellene este campo"
				},
				dni:{
					minlength: "El dni debe contener {0} caracteres",
					maxlength:"Maximo de {0} caracteres",
					validar_dni:"El valor introducido no es correcto",
					required:"Rellene este campo"
				},
				email:{ 
					formEmail: "El formato introducido no es correcto",
					required:"Rellene este campo"
				},
				fecha_nacimiento:{
					required:"Rellene este campo"
				},
				tlf:{
					minlength: "Introduce al menos {0} caracteres",
					maxlength:"Maximo de {0} caracteres",
					number:"Solo debe contener numeros",
					required:"Rellene este campo"
				},
			//Mensajes de error para el domicilio fiscal...
			//
				tipo_via:{
					required:"Rellene este campo"
				},
				direccion: {
					minlength: "Introduce al menos {0} caracteres",
					maxlength:"Maximo de {0} caracteres",
					required:"Rellene este campo"
				},
				comp_direccion:{
					minlength: "Introduce al menos {0} caracteres",
					maxlength:"Maximo de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos"
				},
				numero: {
					number:"Solo debe contener números",
					min:"El valor debe ser superior a 0",
					required:"Rellene este campo",
					max:"Valor máximo 200"
				},
				piso: {
					maxlength:"Maximo de {0} caracteres",
					required:"Rellene este campo"
				},
				puerta: {
					maxlength:"Maximo de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos"
				},
				escalera: {
					maxlength: "No debe contener más de {0} caracteres"
				},
				cod_postal: {
					minlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					number:"Solo debe contener numeros",
					min:"El valor debe ser superior a 0",
					required:"Rellene este campo"
				},
				localidad: {
					mminlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",
					required:"Rellene este campo"
				},
				provincia:{ 
					minlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",
					required:"Rellene este campo"
				},
				pais: {
					minlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",
					required:"Rellene este campo"
				},
			//Mensajes de error para el domicilio social...
			//
				direccion_2: {
					minlength: "Introduce al menos {0} caracteres",
					maxlength:"Máximo de {0} caracteres",	
				},
				comp_direccion:{
					minlength: "Introduce al menos {0} caracteres",
					maxlength:"Maximo de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos"
				},
				numero_2: {
					number:"Solo debe contener numéricos",
					min:"El valor debe ser superior a 0",	
					max:"valor máximo 200"
				},
				piso_2: {
					maxlength:"Máximo de {0} caracteres",		
				},
				puerta_2: {
					maxlength:"Máximo de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos"
				},
				escalera_2: {
					maxlength: "No debe contener más de {0} caracteres"
				},
				cod_postal_2: {
					minlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					number:"Solo debe contener números",
					min:"El valor debe ser superior a 0"
				},
				localidad_2: {
					mminlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",		
				},
				provincia_2:{ 
					minlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",		
				},
				pais_2: {
					minlength: "Introduce al menos {0} caracteres",
					maxlength: "No debe contener más de {0} caracteres",
					validar_solo_letras:"No debe contener valores numéricos",		
				},
			},
			errorElement : 'span'
		});
	});
});