<?php
$titulo ="AREA PERSONAL";
require_once(dirname(__FILE__)."/../../resources/inc/html/header.php");
require_once(dirname(__FILE__)."/../../resources/inc/html/menu.php");
?>
        <contenido>
            <div id="cont_us">
                <div id="info">
                    <div id="img_us"></div> 
                    <div class="item_info">    
                        <label for="id">ID:</label>
                        <span id="id" ></span>
                    </div>
                    <div class="item_info"> 
                        <label for="nombre" >Nick:</label>
                        <span id="nombre" ></span>
                    </div>
                    <div class="item_info">
                        <label for="email" >Email:</label>
                        <span id="email" ></span>  
                    </div>  
                </div>
                <div id="cont_editar_us">
                    <div class="tit_sec">
                        <h2>Datos de mi cuenta</h2>
                    </div>
                    <form action="#" id="form_editar_dat" name="form_editar_dat" enctype="multipart/form-data">
                        <div class="item_ed">
                            <label for="nuevo_nombre">Nombre:</label><br>
                            <input type="text" id="nuevo_nombre" name="nuevo_nombre" maxlength="30" required>
                        </div>
                        <div class="item_ed">
                            <label for="nuevo_email">Email:</label><br>
                            <input type="email" id="nuevo_email" name="nuevo_email" maxlength="80" required>
                        </div>
                        <div  class="cont_btn_ed_dat">
                            <button type="button" id="btn_dat">Guardar</button>
                        </div>
                    </form>
                    <div class="tit_sec">
                        <h2>Cambiar contraseña</h2>
                    </div>
                    <form action="#" id="form_editar_pass" name="form_editar_pass">
                        <span id="fail"></span>
                            <div class="item_ed">
                                <label for="pass_ant">Antigua contraseña:</label><br>
                                <input type="password" id="pass_ant" name="pass_ant" maxlength="20" required>
                            </div>
                            <div class="item_ed">
                                <label for="nw_pass">Nueva contraseña:</label><br>
                                <input type="password" id="nw_pass" name="nw_pass" minlength="6" maxlength="20" required>
                            </div>
                            <div class="item_ed">
                                <label for="comp_nw_pass">Repite contraseña:</label><br>
                                <input type="password" id="comp_nw_pass" name="nw_pass" required>
                            </div>
                            <div  class="cont_btn_ed_dat">
                                <button type="button" id="btn_pass">Guardar</button>
                            </div>      
                    </form>
                </div>
            </div>
        </contenido>
        <script src="../js/area_us.js"></script>
        <script src="../js/rules_val.js"></script>
    </body>
</html>