<?php
$peticionAjax=true;
require_once "../config/app.php";

if(false){
    /**************Instancia al controlador*************** */
    require_once "../controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();

}else{
    session_start(['name'=>'IKEO']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}