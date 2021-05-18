 
 $(document).ready(function(){
    //Comprobamos que el us estse log correctamente...
    //
    var statusLog = localStorage.getItem("LOGGED");
    if(statusLog != "YES")
    {
        window.location.replace("http://localhost/index.php");
    }
    else
    {
        //Creamos un obj js con la acción a realizar y el id...
        //
        var contenido = new Object();
        var accion = $("#accion").val();
        contenido['accion'] = "MOSTRAR";
        contenido['id'] =  $("#id").val();
        //Lo parseamos a formato Json...
        //
        json_contenido = JSON.stringify(contenido);
        //Validamos que la acción escogida sea correcta...
        //
        if(accion == false)
        {
            alert("No llega información de la acción a realizar");
        }
        else 
        {
            //En el caso de que la acción requerida sea EDITAR validamos si el id del usuario que queremos editar es correcto, en cuyo caso mostraremos sus datos mediante el metodo mostrar()...
            //
            if(accion == "EDITAR")
            {
                if(id == 0)
                {
                    alert("No llega información del id ");
                }
                else
                {
                    mostrar(json_contenido);
                }
            }     
        }
    } 
}); 
function mostrar(json_contenido)
{
    //Instanciamos los parametros que pasaremos al serv...
    //
    parametro={
        "datos" : json_contenido
    }
    $.ajax({
        data: parametro,
        url: '/../../resources/controller/controlador.php',
        method: 'post',
        dataType:'json'
    }).done(function(respuesta){ 
        //En el caso de que la petición Ajax sea correcta recogemos los valores que nos devuelve el serv en json y los colocamos en su respectivo lugar...
        //
            //Datos personales usuario a editar...
            //
            var nombre = respuesta.usuario.nombre;
            var ap_1 = respuesta.usuario.primer_apellido;
            var ap_2 = respuesta.usuario.segundo_apellido;
            var dni = respuesta.usuario.dni;
            var estado_civil = respuesta.usuario.estado_civil;
            var fecha = respuesta.usuario.fecha_nacimiento;
            var sexo = respuesta.usuario.sexo;
            var tlf = respuesta.usuario.telefono;
            var email = respuesta.usuario.email;
            $("#nombre").val(nombre);
            $("#primer_apellido").val(ap_1);
            $("#segundo_apellido").val(ap_2);
            $("#dni").val(dni);
            $("#sexo").val(sexo);
            $("#fecha_nacimiento").val(fecha);
            $("#estado_civil").val(estado_civil);
            $("#email").val(email);
            $("#tlf").val(tlf);
            //Datos domicilio fiscal ...
            //
            var cod_postal = respuesta.dom_fis.cod_postal;
            var comp_direccion = respuesta.dom_fis.comp_direccion;
            var direccion = respuesta.dom_fis.direccion;
            var escalera = respuesta.dom_fis.escalera;
            var localidad = respuesta.dom_fis.localidad;
            var numero = respuesta.dom_fis.numero;
            var pais = respuesta.dom_fis.pais;
            var piso = respuesta.dom_fis.piso;
            var provincia = respuesta.dom_fis.provincia;
            var puerta = respuesta.dom_fis.puerta;
            var tipo_via = respuesta.dom_fis.tipo_via;
            $("#tipo_via").val(tipo_via);
            $("#direccion").val(direccion);
            $("#escalera").val(escalera);
            $("#piso").val(piso);
            $("#puerta").val(puerta);
            $("#cod_postal").val(cod_postal);
            $("#localidad").val(localidad);
            $("#provincia").val(provincia);
            $("#pais").val(pais);
            $("#numero").val(numero);
            $("#comp_direccion").val(comp_direccion);
            //Datos domicilio social...
            //
           var cod_postal_2 = respuesta.dom_soc.cod_postal;
            var comp_direccion_2 = respuesta.dom_soc.comp_direccion;
            var direccion_2 = respuesta.dom_soc.direccion;
            var escalera_2 = respuesta.dom_soc.escalera;
            var localidad_2 = respuesta.dom_soc.localidad;
            var numero_2 = respuesta.dom_soc.numero;
            var pais_2 = respuesta.dom_soc.pais;
            var piso_2 = respuesta.dom_soc.piso;
            var provincia_2 = respuesta.dom_soc.provincia;
            var puerta_2 = respuesta.dom_soc.puerta;
            var tipo_via_2 = respuesta.dom_soc.tipo_via;
            $("#tipo_via_2").val(tipo_via_2);
            $("#direccion_2").val(direccion_2);
            $("#escalera_2").val(escalera_2);
            $("#piso_2").val(piso_2);
            $("#puerta_2").val(puerta_2);
            $("#cod_postal_2").val(cod_postal_2);
            $("#localidad_2").val(localidad_2);
            $("#provincia_2").val(provincia_2);
            $("#pais_2").val(pais_2);
            $("#numero_2").val(numero_2);
            $("#comp_direccion_2").val(comp_direccion_2);
            //En el caso de que la petición Ajax falle capturamos y personalizamos el mensaje de error...
            //
    }).fail(function( jqXHR, textStatus, errorThrown ){ 
        if (jqXHR.status === 0) 
        {
            alert('Not connect: Verify Network.');
        } 
        else if (jqXHR.status == 404) 
        {
            alert('Requested page not found [404]');
        } 
        else if (jqXHR.status == 500) 
        {
            alert('Internal Server Error [500].');
        } 
        else if (textStatus === 'parsererror') 
        {
            alert("Request parse error");
        } 
        else if (textStatus === 'timeout') 
        {
            alert('Time out error.');
        } 
        else if (textStatus === 'abort') 
        {
            alert('Ajax request aborted.');
        }
        else
        {
            alert('Uncaught Error: ' + jqXHR.responseText); 
        }
    });
}
     
