$( document ).ready( function()
{
    $("#guardar").click(function(){
        //Validamos el formulario al pulsar el "boton" guardar...
        //
        var accion = $("#accion").val();
       if($("#form_datos_personales").valid())
       {
           //creamos un objeto js llamado contenido...
           //
            var contenido = new Object();
            //recogemos los valores de todos los campos rellenables del formuario(inputs , options...)...
            //
            var contenido_form = document.querySelectorAll("input");
            //creamos un atributo para el obj creado con el valor correspondiente de cada campo del formulario(respetando los nombres del form...)...
            //
            contenido_form.forEach(element => {
                contenido[element.id] = element.value;
            });
            contenido['estado_civil'] = $("#estado_civil").val();
            contenido['sexo'] = $("#sexo").val();
            contenido['tipo_via'] = $("#tipo_via").val();
            contenido['tipo_via_2'] = $("#tipo_via_2").val(); 
            //Parseamos el objeto con todos los datos a formato json...
            //
            json_contenido = JSON.stringify(contenido);
            //Mediante la función Ajax add_upd mandamos el objeto parseado al serv para que ejecute la accion correspondiente...
            // 
            add_upd(json_contenido , accion);   
       }
       else
       //En el caso de que alguno de los valores del formulario no sea correcto no haremos nada...
       //
       {   
       } 
    });
});
function add_upd(json_contenido , accion)
{
    //Instanciamos los parametros para enviar al ser(Json)...
    //
    parametros={
        "datos": json_contenido  
    }
    $.ajax({
        data: parametros,
        url: '/../../resources/controller/controlador.php',
        method: 'post',
        dataType: 'json'
    }).done(function(respuesta){
        //En el caso de que la petición Ajax se ejecute correctamente se muestra la respuesta...
        //
        alert(JSON.stringify(respuesta.respuesta));
        if(accion == "AÑADIR")
        {
            $("input").val(" ");
        }
        //En caso de que la petición Ajax falle , capturamos la ex y personalizamos el mensaje de error según la ex que sea...
        //
    }).fail(function( jqXHR, textStatus, errorThrown){
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
            alert('Requested JSON parse failed.');
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
