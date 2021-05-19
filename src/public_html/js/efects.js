
$(document).ready(function(){
    $("#flecha").html("&#709;");
    var nombre = localStorage.getItem("NOMBRE");
    var inicial = nombre.charAt(0);
    var inicialMay = inicial.toUpperCase();
    $("#inicial").html(inicialMay);
    $("#nombre_menu").html(nombre);
    $("#clientes_op").mouseover(function(){ 
        $("#flecha").html("&#8963;");
    });
    $("#clientes_op").mouseleave(function(){
        $("#flecha").html("&#709;");
    });
});