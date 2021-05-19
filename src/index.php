<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script>
<link type="text/css" rel="stylesheet" href="/public_html/css/style.css">
</head>
    <body>
        <div id="menu_log">
            <a href="#" id="registrarse" name="registrarse">Register</a>
            <a href="#" id="login" name="login">Login</a>
        </div>
        <div id="cont_log">
            <form action="" method="post" name="form_login" id="form_login">
                <div id="titulo_login"></div>
                <span id="error_log"></span>
                <div id="contenido"></div>
                <div id="cont_btn">
                    <button type="button" id="btn_login" class="log_item">Login</button><br>
                </div>
            </form>
        </div>
        <a href="/public_html/view/mostrar.php">listado</a>
        <script src="/public_html/js/log.js"></script>
        <script src="/public_html/js/rules_val.js"></script>
    </body>
</html>