$(document).ready(function(){
    //Validamos log...
    //
    var statusLog = localStorage.getItem("LOGGED");
    if(statusLog != "YES")
    {
        window.location.replace("http://localhost/index.php");
    }
    else
    {
        datos();
        $("#btn_dat").click(function(){
            if($("#form_editar_dat").valid())
            {
                //Creamos un obj con todos los nuevos datos del form...
                //
                var formDatos = new Object();
                formDatos.accion = "UPD_US";
                formDatos.nombre = $("#nuevo_nombre").val();
                formDatos.email = $("#nuevo_email").val();
                var json_formDatos = JSON.stringify(formDatos);
                //Ejecutamos la sentecia ajax para modificarlos en la bd...
                //
                updDatos(json_formDatos);
                //Recargamos el form con los nuevo valores del us(cambiamos la petición ajax a sincrona 
                //para asegurarnos de que la ejecución de la pet se lleva a cabo en el orden correcto)...
                //
                datos();
            }
        });
        $("#btn_pass").click(function(){
            if($("#form_editar_pass").valid())
            {
                var pass = $("#pass_ant").val();
                var newPass = $("#nw_pass").val();
                var newPassComp = $("#comp_nw_pass").val();
                if(newPass != newPassComp)
                {
                    $("#fail").html("La nueva contraseña y su repetición no coinciden...");
                }
                else
                {
                    var nwPass = new Object();
                    nwPass.accion = "UPD_PASS";
                    nwPass.pass = newPass;
                    nwPass.pass_ant = pass;
                    var json_newPass = JSON.stringify(nwPass);
                    updPass(json_newPass);
                }
            }
        });
    }
});

function  datos()
{
    var contenido = new Object();
    contenido.accion = "DATOS_US";
    var json_contenido = JSON.stringify(contenido);
    parametros={
        "datos":json_contenido
    }
    $.ajax({
        async:false,
        data:parametros,
        url:'http://localhost/resources/controller/controlador_login.php',
        method:'post',
        dataType:'json'
    }).done(function(respuesta){
        console.log(respuesta);
        var nombre = respuesta.nombre;
        var email = respuesta.email;
        var id = respuesta.id;
        var modificacion = respuesta.modificacion;
        //Recogemos los valores modificados del usuario en el storage...
        //
        localStorage.setItem("NOMBRE" ,nombre);
        localStorage.setItem("EMAIL" , email);
        console.log(localStorage);
        //Mostramos la imagen de pefil y los datos del us...
        //
        $("#id").html(id);
        $("#nombre").html(nombre);
        $("#email").html(email);
        //En cada input introducimos el valor correspondiente...
        //
        $("#nuevo_nombre").val(nombre);
        $("#nuevo_email").val(email);

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
//Esta función ejecuta la pet ajax , edita el nombre y el email del us y devuelve el mensaje correspondiente...
//
function updDatos(json_formDatos){
    parametros={
        "datos":json_formDatos
    }
    $.ajax({
        async:false,
        data:parametros,
        url:'http://localhost/resources/controller/controlador_login.php',
        method:'post',
        dataType:'json'
    }).done(function(respuesta){
        alert(JSON.stringify(respuesta.respuesta));
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
//Esta función edita la pass del us...
//
function updPass(json_newPass)
{
    parametros={
        "datos":json_newPass
    }
    $.ajax({
        data:parametros,
        url:'http://localhost/resources/controller/controlador_login.php',
        method:'post',
        dataType:'json'
    }).done(function(respuesta){
       alert(JSON.stringify(respuesta.respuesta));
       $("#form_editar_pass>#item_ed>input").val("");
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
