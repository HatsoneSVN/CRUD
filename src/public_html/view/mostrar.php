<?php
$titulo ="LISTADO";
require_once(dirname(__FILE__)."/../../resources/inc/html/header.php");
require_once(dirname(__FILE__)."/../../resources/inc/html/menu.php");
?>
        <contenido>
            <div id="contenedor_tabla_busquedas">
                <div id="cont_bus_add">
                    <div id="nuevo_usuario">
                        <img src="../img/icono_añadir.png" alt="add">
                        <a href="/public_html/view/add_upd.php?accion=AÑADIR" id="nuevo">Nuevo+</a>
                    </div>
                    <div id="cant_val">
                        <select name="limit" id="limit">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                    <div id="contenedor_buscador">
                        <input type="text" name="buscador" id="buscador" placeholder="Search...">
                    </div>
                </div>
                    <table id='usuarios'>
                        <thead>
                            <tr>
                                <th>Nº Usuario</th>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th colspan="2" class="doble">Apellidos</th>
                                <th>E-mail</th>
                                <th>Teléfono</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>    
                <div id="pag">
                    <div id="cont_pag">
                        <div class="item_pg"><button id="ultima"><span>&#187</span></button></div>
                        <div class="item_pg" ><button id="siguiente"><span>&#8250</span></button></div>
                        <div id="indicador_paginas">
                            <select id='num_pg' name='num_pg'>
                            </select>
                        </div>
                        <div class="item_pg"><button id="anterior"><span>&#8249</span></button></div>
                        <div class="item_pg"><button id="primera">&#171</button></div>
                    </div>
                </div>
            </div>
        </contenido>
        <script src="../js/tb_ajax.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    </body>
</html>
