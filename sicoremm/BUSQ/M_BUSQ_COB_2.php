

<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Afiliados.php');

function fecha_normal_a_mysql($fecha){
  
    $cambio = explode('-',$fecha);
    
    $fecha_final = $cambio[2].'-'.$cambio[1].'-'.$cambio[0];
    
    return $fecha_final;
    
}

function pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion){


    $fecha_mov1 = fecha_normal_a_mysql($fecha_mov);
    $fecha_vto2 = fecha_normal_a_mysql($fecha_vto);
    $fecha3 = fecha_normal_a_mysql($fecha);

    $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'".$nro_doc."','".$tipo_comp."','50','".$comprovante."','".$cod_mov."','".$afectacion."','".$fecha_mov1."','".$fecha_vto2."','".$importe."','".$cobrador."','".$num_solici."','".$fecha3."','".$debe."','".$haber."','".$rendicion."')";
    return $insert_sql;

}


foreach ($_POST AS $campo=>$valor){

    if ($valor ==  ""){
        echo '<div class="mensaje2>Llene todos los campos</div>"';
        exit;
    }
}

$importe = $_POST['importe'] / $_POST['periodo'];

$fecha_ing = $_POST['fecha'];




$f_inicio = explode('-',$_POST['pinicial']);

    $dia ='1';
    $mes =$f_inicio[0];
    $anio =$f_inicio[1];

  
for ($i =0 ; $i < $_POST['periodo']; $i ++){


    if ($mes > 12){
        $mes = 1;
        $anio = $anio +1;
    }


    $fecha_mov = $dia.'-'.$mes.'-'.$anio;
    
    //echo '<br />'.$fecha_mov.'<br />';
    //pago_cta($nro_doc,         $tipo_comp,    $comprovante, $cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion)
    $query['mensualidad'.$i]= pago_cta($_POST['nro_doc'],$_POST['tipo'],$_POST['documento'],1,$_POST['documento'] ,$fecha_mov,$fecha_mov,$importe,$_POST['cobrador'],$_POST['num_solici'],$fecha_ing,$importe,0,$_POST['rendicion']);
    $query['pago'.$i]= pago_cta($_POST['nro_doc'],$_POST['tipo'],$_POST['documento'],$_POST['tipo_comp'],$_POST['documento'],$fecha_mov,$fecha_mov,$importe,$_POST['cobrador'],$_POST['num_solici'],$fecha_ing,0,$importe,$_POST['rendicion']);

    $mes ++;
}

$tran = new Datos;
$tran->Trans($query);
?>
