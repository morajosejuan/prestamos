<?php
$peticionAjax=true;
require_once "../config/app.php";

if(){
    /**************Instancia al controlador*************** */
    

}else{
    session_start(['name'=>'IKEO']);
    session_unset();
    session_destroy();
    header("Location: ".SERVERURL."login/");
    exit();
}