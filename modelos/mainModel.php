<?php
if($peticionAjax){
    require_once "../config/server.php";
}else{
    require_once "./config/server.php";

}

class mainModel {

        /*-------------Función para Conectar a la BD-------------*/
        protected static function conectar(){
            $conexion = new PDO(SGBD,USER,PASS);
            /*-----Permite recibir Ñ-----*/
            $conexion ->exec("SET CHARACTER SET utf8");  
            return $conexion;
        }

        /*-------------Función para ejecutar consulta simples---------*/
        protected static function ejecutar_consulta_simple($consulta){
            $sql=self::conectar()->prepare($consulta);
            $sql->execute();
            return $sql;

        }

         /*-------------Función para encryptar datos---------*/

        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

        /*-------------Función para desencryptar datos---------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

        /*-------------Función para generar codigos aleatorios---------*/
        protected static function generar_codigo_aletorio($letra,$longitud,$numero){
            for($i=1; $i<=$longitud; $i++){
                $aleatorio=rand(0,9);
                $letra.=$aleatorio;

            }
            return $letra."-".$numero;

        }

         /*-------------Función para limpiar cadenas---------*/
         protected static function limpiar_cadena($cadena){
            
            $cadena=str_ireplace("<script>","",$cadena);
            $cadena=str_ireplace("<script src","",$cadena);
            $cadena=str_ireplace("<script type=","",$cadena);
            $cadena=str_ireplace("SELECT * FROM","",$cadena);
            $cadena=str_ireplace("DELETE FROM","",$cadena);
            $cadena=str_ireplace("INSERT INTO","",$cadena);
            $cadena=str_ireplace("DROP TABLe","",$cadena);
            $cadena=str_ireplace("DROP DATABASE","",$cadena);
            $cadena=str_ireplace("TRUNCATE TABLE","",$cadena);
            $cadena=str_ireplace("SHOW TABLES","",$cadena);
            $cadena=str_ireplace("SHOW DATABASES","",$cadena);
            $cadena=str_ireplace("<?PHP","",$cadena);
            $cadena=str_ireplace("?>","",$cadena);
            $cadena=str_ireplace("--","",$cadena);
            $cadena=str_ireplace("<","",$cadena);
            $cadena=str_ireplace(">","",$cadena);
            $cadena=str_ireplace("[","",$cadena);
            $cadena=str_ireplace("]","",$cadena);
            $cadena=str_ireplace("^","",$cadena);
            $cadena=str_ireplace("==","",$cadena);
            $cadena=str_ireplace(";","",$cadena);
            $cadena=str_ireplace(":::","",$cadena);
            $cadena=stripcslashes($cadena); //elimina los barras invertidas \
            $cadena=trim($cadena); //borra espacios
            return $cadena;


         }
         
         /*-------------Función para verificar datos---------*/
         protected static function verificar_datos($filtro,$cadena){
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;

            }else{
                return true;

            }

         }

         /*-------------Función para verificar fechas---------*/
        protected static function verificar_fecha($fecha){
            $valores=explode('-',$fecha);
            if(count($valores)==3 && checkdate($valores[1],$valores[2],$valores[0])){
                return false;
            }else{
                return true;
            }
        }
        
        /*-------------Función paginardor de tablas---------*/
        protected static function paginador_tablas($pagina,$Npaginas,$url,$botones){
            $tabla='<nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">';
            if($pagina==1){
                $tabla.='<li class="page-item disabled">
                        <a class="page-link" >
                        <i class="fa-light fa-circle-arrow-left"></i>
                        </a>
						</li>';
            }else{
                $tabla.='
                <li class="page-item">
                        <a class="page-link" href="'.$url.'1/" >
                        <i class="fa-light fa-circle-arrow-left"></i>
                        </a>
						</li>
                        <li class="page-item">
                        <a class="page-link" href="'.$url.($pagina-1).'/" >
                            Anterior</a>
						</li>
                        ';                      
            }

            $ci=0;
            for($i=$pagina;$i<=$Npaginas; $i++){
                if($ci>=$botones){
                    break;
                }

                if($pagina==$i){
                    $tabla.='<li class="page-item">
                    <a class="page-link active" href="'.$url.$i.'/" >
                    '.$i.'</a> </li>';

                }else{
                    $tabla.='<li class="page-item">
                    <a class="page-link " href="'.$url.$i.'/" >
                    '.$i.'</a> </li>';

                }
                $ci++;

            }

            if($pagina==$Npaginas){
                $tabla.='<li class="page-item disabled">
                        <a class="page-link" >                            
                            <i class="fa-light fa-circle-arrow-right"></i>
                        </a>
                        </li>';
            }else{
                $tabla.='
                
                       
                        <li class="page-item">
                        <a class="page-link" href="'.$url.($pagina+1).'/" >
                            Siguiente</a>
                        </li>

                        <li class="page-item">
                        <a class="page-link" href="'.$url.$Npaginas.'/" >
                        <i class="fa-light fa-circle-arrow-right"></i>
                        </a>
                        </li>
                        ';

            }

            $tabla.='</ul> </nav>';
            return $tabla;
        }


}