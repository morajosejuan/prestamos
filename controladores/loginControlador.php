<?php
if($peticionAjax){
    require_once "../modelos/loginModelo.php";
}else{
    require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo{

     /**************Controlador iniciar sesion*************** */
     public function iniciar_sesion_controlador(){
        $usuario=mainModel::limpiar_cadena($_POST['usuario_log']);
        $clave=mainModel::limpiar_cadena($_POST['clave_log']);

         /**************Comprobar campos vacios*************** */
         if($usuario=="" || $clave==""){
            echo '<script> 
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "No ha llenado todos los campos requeridos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            
            </script>';
            exit();
         }
         /**************Verificando la integridad de los datos*************** */
         if(mainModel::verificar_datos("[a-zA-Z0-9]{2,35}",$usuario)){
            echo '<script> 
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "El NOMBRE de usuario no permite cierto caracteres no validos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            
            </script>';
            exit();

         }

         if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
            echo '<script> 
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "La clave de usuario no permite cierto caracteres no validos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            
            </script>';
            exit();

         }
         $clave=mainModel::encryption($clave);
            $datos_login=[
                "Usuario"=>$usuario,
                "Clave"=>$clave
            ];
            $datos_cuenta=loginModelo::iniciar_sesion_modelo($datos_login);
            if($datos_cuenta->rowCount()==1){
                $row=$datos_cuenta->fetch();
                session_start(['name'=>'IKEO']);
                $_SESSION['id_ikeo']=$row['usuario_id'];
                $_SESSION['nombre_ikeo']=$row['usuario_nombre'];
                $_SESSION['apellido_ikeo']=$row['usuario_apellido'];
                $_SESSION['usuario_ikeo']=$row['usuario_usuario'];
                $_SESSION['privilegio_ikeo']=$row['usuario_privilegio'];
                $_SESSION['dni_ikeo']=$row['usuario_dni'];
                $_SESSION['token_ikeo']=md5(uniqid(mt_rand(),true));
                return header("location: ".SERVERURL."home/");



            }else{
                echo '<script> 
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "El Usuario o Clave ingresado no son validos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
            
            </script>';

            }
    }/*****Fin del controlador******/

    /*****Controlador para forzar el cierre de session******/
    public function forzar_cierre_sesion_controlador(){
        session_unset();
        session_destroy();
        if(headers_sent()){
            return "<script> window.location.href='".SERVERURL."login/';</script>";

        }else{
            return header("Location: ".SERVERURL."login/");

        }

    }/*****Fin del controlador******/


}