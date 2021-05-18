$(document).ready(function()
{
    $("#salir").click(function()
    {
        var contenido = new Object();
        contenido.accion = "SALIR";
        var json_contenido = JSON.stringify(contenido);
        var conf = confirm("Esta seguro de que desea cerrar la sesión??");
        if(conf == true)
        {
            cerrarSesion(json_contenido);
        }
    });
});
function cerrarSesion(json_contenido)
{
    var parametros={
        "datos":json_contenido
    }
    $.ajax({
        data:parametros,
        url:'http://localhost/resources/controller/controlador_login.php',
        method:'post',
        dataType:'json'
    }).done(function(respuesta){
        //Limpiamos el storage y nos trasladamos a la vista de login...
        //
        localStorage.clear();
        window.location.replace("http://localhost/index.php");
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