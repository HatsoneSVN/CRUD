
var offset = 0;
var limit = 10;
$( document ).ready( function()
{   
    //Comprobamos si el usuario esta logeado...
    //
    var statusLog = localStorage.getItem("LOGGED");
    if(statusLog != "YES")
    {
        window.location.replace("http://localhost/index.php");
    }
    else
    {
        //En cuanto carga la página dibujamos la tabla con los valores por defecto...
        //
        tabla(offset , limit );
        $("#limit").change(function(){
            limit = $("#limit").val();
            offset = 0;
            tabla(offset , limit);
        });
        //Al cambiar el número de la página la tabla se recarga con los valores correspondientes...
        //
        $("#num_pg").change(function(){
            offset = parseInt($("#num_pg").val()) * parseInt(limit);
            tabla(offset , limit);
        });
        //Evento de siguiente...
        //
        $("#siguiente").click(function(){
            offset = parseInt(offset) + parseInt(limit);
            tabla(offset , limit);
        });
        //Evento de anterior...
        //
        $("#anterior").click(function(){
            offset = offset - limit;
            tabla(offset , limit);
        });
        //Al pulsar el boton de primera se recarga la tabla con los valores correspondientes...
        //
        $("#primera").click(function(){
            offset = 0;
            tabla(offset , limit);
        });
        //Al pulsar el boton de última se recarga la tabla con los valores correspondientes...
        //
        $("#ultima").click(function(){
            offset = ($("#total").val()) * limit;
            tabla(offset , limit);
        });
        //Evento que filtra el contenido de la tabla en funcion de los parametros introducidos en el buscador...
        //
        $("#buscador").keyup(function(){
            tabla(offset , limit);
        });
    }
});
//Esta función se encarga de confirmar y ejecutar la eliminación...
//
function eliminar(elemento)
{
    id = elemento.id;
    var conf = confirm("Está seguro de que desea eliminar el usuario con id " + id);
        if(conf == true)
        {
            ejecutar_eliminar(id);
            tabla(offset , limit);
        }
        else
        {
            alert("Eliminación cancelada");
        }      
}
function tabla(offset , limit , contenido)
{
    var cant_rows = 0;
    var usuarios = [];
    var tabla="";
    var posicion = Math.ceil(offset /limit); 
    var contenido = new Object();   
    contenido['char'] = $("#buscador").val();
    contenido['offset'] = offset;
    contenido['accion'] = "FILTRAR";
    contenido['limit'] = limit;
    json_contenido = JSON.stringify(contenido);
    var parametros = {
        "datos" : json_contenido
    }
    //En el caso de que la petición ajax se lleve a cabo correctamente....
    //
    $.ajax({
        data: parametros,
        url: '/../../resources/controller/controlador.php',
        method: 'post',
        dataType: 'json'
        }).done(function(respuesta){ 
            respuesta.forEach(function(respuesta , key)
            {
                usuarios[key] =
                        "<tr>"+
                            "<td>"+respuesta.id+"</td>"+
                            "<td>"+respuesta.dni+"</td>"+
                            "<td>"+respuesta.nombre+"</td>"+
                            "<td>"+respuesta.primer_apellido+"</td>"+
                            "<td>"+respuesta.segundo_apellido+"</td>"+
                            "<td>"+respuesta.email+"</td>"+
                            "<td>"+respuesta.telefono+"</td>"+
                            "<td><a href='add_upd.php?accion=EDITAR&&id="+respuesta.id+"'><img src='../img/editar.png' alt='editar'></a></td>"+
                            "<td><a href='#' onClick='eliminar(this)' id='"+respuesta.id+"' class='eliminar'><img src='../img/eliminar.png' alt='eliminar'></a></td>"+
                        "</tr>";
            });
            //Estructuramos la tabla
            //
            for (let i = 0; i < usuarios.length; i++) 
            {
                tabla+=usuarios[i];
            } 
            $("#usuarios>tbody").html(tabla);
            //Calculamos el número de pg y creamos un selector con el número de opciones equivalente...
            //
            if(respuesta.length == 0)
            {
                $("#usuarios>tbody").html("<tr>"+
                "<td colspan='10'><b>Usuario no encontrado<b></td>" +
                "</tr>");
            }
            else
            {
                var cont_rows = respuesta[0].rows;
            }
            cant_rows =  Math.ceil(cont_rows/limit);
            var paginas = "";
            var val_posicion = posicion + 1;
            //Generamos el paginado en formato option...
            //
            for (let i = 0; i < cant_rows; i++) {
                if(i == posicion)
                {
                    //Para mostrar siempre la opción equivalente a la página  en la que nos encontramos
                    //buscamos la similitud del option creado con la posición y se selecciona...
                    paginas+="<option value='"+(i)+"' selected>"+(i+1)+"</option>";
                }
                else if(i == cant_rows-1)
                {
                    paginas+="<option value='"+(i)+"' id='total'>"+(i+1)+"</option>";
                }
                else
                {
                    paginas+="<option value='"+(i)+"'>"+(i+1)+"</option>";
                }       
            }
            $("#num_pg").html(paginas);
            //Según en la pg en la que nos encontremos mostramos unos botones u otro...
            //      
            if(val_posicion == cant_rows || usuarios.length < limit)
            {
                $("#siguiente").css("display" , "none");
            }
            else
            {
                $("#siguiente").css("display" , "inline");
            }
            if(val_posicion == 1 )
            {
                $("#anterior").css("display" , "none");
            }
            else
            {
                $("#anterior").css("display" , "inline");
            }         
    //En el caso de que la petición ajax falle...
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
                alert('Request parse error');    
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
//Función que elimina los usuarios
//
function ejecutar_eliminar(id)
{
    var contenido = new Object();
    contenido['accion'] = "ELIMINAR";
    contenido['id'] = id;
    json_contenido = JSON.stringify(contenido);
    var parametros ={
         "datos" : json_contenido,
    }
    $.ajax({
        async: false,
        data: parametros,
        url: '/../../resources/controller/controlador.php',
        method: 'post',
        dataType:'json'
        }).done(function(respuesta){
            if(respuesta.respuesta == "OK")
            {
                alert("El usuario se ha eliminado correctamente");
            }
            else
            {
                alert("Erro al eliminar el usuario");
            }
        }).fail(function( jqXHR, textStatus, errorThrown , respuesta ){
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
                alert('Request parse error');
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


