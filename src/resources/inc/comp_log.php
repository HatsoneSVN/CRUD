<?php
session_start();
if(empty($_SESSION['LOGGED']))
{
    header("location:/../../index.php");
}
?>
