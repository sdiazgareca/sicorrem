<?php
include_once('../../DAT/conf.php');
include_once('../../DAT/bd.php');
include_once('../../CLA/Datos.php');

//INGRESAR USUARIO
if ($_POST['guardar_usuario'] > 0){



    if($_POST['clave1'] == $_POST['clave2']){
        $_POST['clave'] = $_POST['clave1'];

    }
    else{
        echo '<div class="mensaje2">Error de clave</div>';
        exit;
    }

    $tran = new Datos;

    $transaccion['ingreso_sql'] ="INSERT INTO usuarios (cod_usuario,clave,nombre,apellido) VALUES('".$_POST['cod_usuario']."','".$_POST['clave']."','".$_POST['nombre']."','".$_POST['apellido']."')";

    foreach ($_POST as $campo => $valor){

        if (is_numeric($campo)){

            $mat = explode("-",$_POST[$campo]);

            $cod_modulo = $mat[0];
            $cod_link   = $mat[1];

            $transaccion[$campo]="INSERT INTO privilegios_reg (cod_modulo,cod_link,cod_usuario) VALUES('".$cod_modulo."','".$cod_link."','".$_POST['cod_usuario']."')";

        }

    }

   $tran->Trans($transaccion);
}

?>
