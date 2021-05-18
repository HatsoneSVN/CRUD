$(document).ready(function(){
    //Comprobamos si el usuario ya está logeado...
    //
    var statusLog = localStorage.getItem("LOGGED");
    //En el caso de que este logeado lo mandaremos directos al home...
    //
    if(statusLog == "YES")
    {
        window.location.replace("http://localhost/public_html/view/home.php");
    }
    else
    {
        //Por defecto el formulario presenta la opción de login , la accion por defecto será logearse...
        //
        $("#titulo_login").html("Login");
        $("#contenido").html(contLogin(false));
        var accion = "LOGIN";
        //En el caso de seleccionar la opción Register , el formulario cambiará el de registro....
        //
        $("#registrarse").click(function(){
            $("#titulo_login").html("Register");
            $("#contenido").html(contLogin(true));
            $("#btn_login").html("Register");
            accion = "REGISTER";
        });
        //En el caso de seleccionar la opción login , de nuevo se mostrará el form de login...
        //
        $("#login").click(function(){
            $("#titulo_login").html("Login");
            $("#contenido").html(contLogin(false));
            $("#btn_login").html("Login");
            accion = "LOGIN";
        });
        $("#btn_login").click(function(){
            //Validamos todos los campos...
            //
            if($("#form_login").valid())
            {
                //Creamos un objeto para recoger los datos del nombre o email y la contaseña del us....
                //
                var contenido = new Object();
                if(accion == "LOGIN")
                {
                    contenido.user = $("#usernameEmail").val(); 
                    contenido.pass =  $("#pass").val();
                    contenido.accion = accion;
                    json_contenido = JSON.stringify(contenido);
                    console.log(json_contenido);
                    compLogin(json_contenido , accion);
                }
                else if(accion == "REGISTER")
                {
                    contenido.user = $("#username").val(); 
                    contenido.email = $("#email").val();
                    contenido.pass =  $("#passR").val();
                    console.log($("#passR").val()+" || "+ $("#pass_comp").val());
                    if($("#passR").val() == $("#pass_conf").val())
                    {
                        contenido.accion = accion;
                        json_contenido = JSON.stringify(contenido);
                        console.log(json_contenido);
                        compLogin(json_contenido , accion);
                    }
                    else
                    {
                        $("#error_log").html("Las contraseñas introducidas no coinciden");
                    }
                }  
            }  
        });
    }
});

function compLogin(json_contenido , accion){
    parametros={
        "datos":json_contenido
    }
    $.ajax({
        data:parametros,
        url:'resources/controller/controlador_login.php',
        method:'post',
        dataType:'json'
    }).done(function(respuesta){
        if(accion == "LOGIN")
        {   
            //En el caso de que se inicie session correctamente recogemos el nombre y el email del us que inicia la session el storage
            // junto con el indicativo de session LOGGED en YES(también se podría hacer con true ,  pero siempre como string)...
            if(respuesta.respuesta.respuesta == "OK")
            {
                localStorage.setItem("NOMBRE" , respuesta.respuesta.usuario.nombre);
                localStorage.setItem("EMAIL" , respuesta.respuesta.usuario.email);
                localStorage.setItem("LOGGED" , "YES");
                window.location.replace("/public_html/view/home.php");
            }
            else
            {
                $("#error_log").html(respuesta.respuesta);
            }  
        }
        if(accion == "REGISTER")
        {
            console.log(respuesta);
            if(respuesta == "OK")
            {
                alert("Usuario registrado correctamente");
                window.location.replace("http://localhost/index.php");
            }
            else
            {
                $("#error_log").html(JSON.stringify(respuesta));
            }
        }
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
function contLogin(registrarse)
{
    if(registrarse == false)
    {
        var login = '<div class="cont">'+
        '<label for="username" id="lab_username "class="log_item" >Username/Email</label><br>'+
            '<input type="text" name="usernameEmail" id="usernameEmail" class="log_item" placeholder="ExamplUser_36 / exampleEmail@gmail.com..."  maxlength="80" required><br>'+
        '</div>'+
        '<div class="cont">'+
            '<label for="pass" id="lab_pass" class="log_item">Password</label><br>'+
            '<input type="password" name="pass" id="pass" class="log_item" maxlength="20" required><br>'+
        '</div>';
    }
    else
    {
        var login = '<div class="cont">'+
        '<label for="name" id="lab_name "class="log_item" >Username</label><br>'+
            '<input type="text" name="username" id="username" class="log_item" maxlength="30" required><br>'+
        '</div>'+
        '<div class="cont">'+
            '<label for="email" id="lab_email" class="log_item">Email</label><br>'+
            '<input type="email" name="email" id="email" class="log_item" required><br>'+
        '</div>'+
        '<div class="cont">'+
            '<label for="pass" id="lab_pass" class="log_item">Password</label><br>'+
            '<input type="password" name="passR" id="passR" class="log_item" minlength="6" maxlength="20" required><br>'+
        '</div>'+
        '<div class="cont">'+
            '<label for="pass_conf" id="lab_pass_conf" class="log_item">Confirm password</label><br>'+
            '<input type="password" name="pass_conf" id="pass_conf" class="log_item" minlength="6" maxlength="20"><br>'+
        '</div>';
    }
    return login;
}