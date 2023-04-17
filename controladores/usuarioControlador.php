<?php
if($peticiomAjax){
    require_once "../modelos/usuarioModelo.php";
}else{
    require_once "./modelos/usuarioModelo.php";
}

class usuarioControlador extends usuarioModelo{

    /**************Controlador agregar usuario*************** */
    public function agregar_usuario_controlador(){
        $dni=mainModel::limpiar_cadena($_POST['usuario_dni_reg']);
        $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
        $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
        $telefono=mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
        $direccion=mainModel::limpiar_cadena($_POST['usuario_direccion_reg']);

        $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
        $email=mainModel::limpiar_cadena($_POST['usuario_email_reg']);
        $clave1=mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
        $clave2=mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);

        $privilegio=mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);
        
        /**************Comprobar los campos vacios*************** */
        if($dni=="" || $nombre=="" || $apellido=="" || $usuario=="" || $clave1=="" || $clave2=="" || $email==""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No ha llenado todos los campos obligatorio",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /**************Verificando la integreda de los datos*************** */
        if(mainModel::verificar_datos("[0-9-]{6,20}",$dni)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La CC no coincide con el formato solicitado",
                "Tipo"=>"error"

            ];
            echo json_encode($alerta);
            exit();

        }


        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",$nombre)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El NOMBRE no coincide con el formato solicitado",
                "Tipo"=>"error"

            ];
            echo json_encode($alerta);
            exit();

        }

        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",$apellido)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El APELLIDO no coincide con el formato solicitado",
                "Tipo"=>"error"

            ];
            echo json_encode($alerta);
            exit();

        }

        if($telefono!=""){
            if(mainModel::verificar_datos("[0-9()+]{10,13}",$telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El TELEFONO no coincide con el formato solicitado",
                    "Tipo"=>"error"
    
                ];
                echo json_encode($alerta);
                exit();
    
            }
        }

        if($direccion!=""){
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{6,190}",$direccion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El DIRECCION no coincide con el formato solicitado",
                    "Tipo"=>"error"
    
                ];
                echo json_encode($alerta);
                exit();
    
            }
        }

        if(mainModel::verificar_datos("[a-zA-Z0-9]{2,35}",$usuario)){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El USUARIO no coincide con el formato solicitado",
                "Tipo"=>"error"

            ];
            echo json_encode($alerta);
            exit();

        }

        if(mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave1) ||mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave2) ){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"Las CLAVES no coincide con el formato solicitado",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();

        }




    }


}