<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');



foreach ($_POST AS $campo=>$valor){

    //echo $campo.' '.$valor.'<br />';

    $cta = explode('/', $valor);

    $num_solici = $cta[0];
    $nro_doc = $cta[1];
    $periodo = $cta[2];
    $importe = $cta[3];
    $factura = $cta[4];
    //comprobar que no exista el periodo
    $sql = "SELECT cta.num_solici FROM cta WHERE cta.fecha_mov='".$periodo."' AND num_solici='".$num_solici."' AND nro_doc='".$nro_doc."'";
    $query = mysql_query($sql);

    $num = mysql_num_rows($query);

    if($num > 0){
        echo '<div class="mensaje2">Periodo Existe en contrato '.$num_solici.'</div>';
    }
    else{
        $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion)
                       VALUES(1,'".$nro_doc."','C','50','".$factura."','1','0','".$periodo."','".$periodo."','".$importe."','10','".$num_solici."','".$periodo."','".$importe."','0',NULL)";
    
         if(mysql_query($insert_sql) > 0){
            echo "<div class='mensaje1'>Periodo $periodo Almacenado en contrato ".$num_solici."</div>";
        }
        else{
           echo '<div class="mensaje2">Error</div>';
        }

    }


}

?>
