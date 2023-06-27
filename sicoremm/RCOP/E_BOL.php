<script type="text/javascript">
$(document).ready(function() {


	$(".poto").submit(function(){

		var url_ajax = $(this).attr("action");
		var data_ajax = $(this).serialize();

		$.ajax({type: "POST",url:url_ajax,cache: false,data:data_ajax,success: function(data) {
		$("#factu_1").html(data);}})

		url_ajax ="";
		data_ajax="";

		return false;});

$('#factu_1 a').click(function() {

 	var ruta = $(this).attr('href');
 	$('#factu_1').load(ruta);
	$.ajax({cache: false});
	ruta ="";
 	return false;
 });


});
</script>

<?php


include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Cta.php');

function pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion){


    $fecha_mov1 =  $fecha_mov;
    $fecha_vto2 = $fecha_vto;
    $fecha3 = $fecha;

    $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'".$nro_doc."','".$tipo_comp."','50','".$comprovante."','".$cod_mov."','".$afectacion."','".$fecha_mov1."','".$fecha_vto2."','".$importe."','".$cobrador."','".$num_solici."','".$fecha3."','".$debe."','".$haber."','".$rendicion."')";
    //echo $insert_sql;
    return $insert_sql;

}



if($_POST['Mensualidad']==1){

    $contrato_sql = "SELECT ZO, SE, MA, num_solici FROM contratos WHERE num_solici='".$_POST['num_solici']."' AND titular='".$_POST['nro_doc']."'";
    $contrato_query = mysql_query($contrato_sql);
    $num = mysql_num_rows($contrato_query);
    $contrato = mysql_fetch_array($contrato_query);

    $f_periodo = explode('-',$_POST['periodo']);
    $periodo = $f_periodo[1].'-'.$f_periodo[0].'-01';

    if ($_POST['cobrador'] == "BUSCAR"){

        $cob_sql = "SELECT cobrador.codigo FROM ZOSEMA INNER JOIN cobrador ON cobrador.nro_doc = ZOSEMA.cobrador
                    WHERE ZOSEMA.ZO='".$contrato['ZO']."' AND ZOSEMA.SE='".$contrato['SE']."' AND ZOSEMA.MA='".$contrato['MA']."'";

        $cob_query = mysql_query($cob_sql);
        $cob = mysql_fetch_array($cob_query);

        $_POST['cobrador'] = $cob['codigo'];

    }
    else{
        $_POST['cobrador'] = $_POST['cobrador'];
    }

    if($num > 0){

        $cta="SELECT cta.nro_doc FROM cta WHERE cta.nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND fecha_mov='".$periodo."' AND cod_mov ='1'";
        
        //echo '<br />'.$cta.'<br />';

        $cta_query = mysql_query($cta);
        $num_cta = mysql_num_rows($cta_query);

        if($num_cta > 0){
            echo '<div class="mensaje2">El periodo existe</div>';
            exit;
        }
        else{


        $in = pago_cta($_POST['nro_doc'],$_POST['t_comprobante'],$_POST['comprobante'],$_POST['tipo_comp'],'0',$periodo,$periodo,$_POST['monto'],$_POST['cobrador'],$_POST['num_solici'],$periodo,$_POST['monto'],0,'');
        if (mysql_query($in)){

            echo '<div class="mensaje1">Mensualidad creada Recaudador '.$_POST['cobrador'].'</div>';
            exit;

        }
        else{

            echo '<div class="mensaje2">Compruebe que los no datos no existen.</div>';
            exit;

        }
        }
    }
    else{
        echo '<div class="mensaje2">El numero de contrato o rut ingresados no corresponden</div>';
        exit;
    }

}


if ($_POST['opcion'] == "eliminar"){


    if($_POST['operador'] == 'D'){

            $query ="DELETE FROM cta where nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND comprovante='".$_POST['comprovante']."'";
            //$query2 = "UPDATE cta SET afectacion='' WHERE nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND comprovante='".$_POST['comprovante']."'";
            $aja = mysql_query($query);
            $_POST['boleta']= $_POST['comprovante'];
            }

    if($_POST['operador'] == 'H'){

            $query ="DELETE FROM cta where cod_mov = '".$_POST['cod_mov']."' AND nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND comprovante='".$_POST['comprovante']."'";
            $query2 = "UPDATE cta SET afectacion='' WHERE nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND comprovante='".$_POST['comprovante']."'";
            $aja = mysql_query($query);
            $aja2 = mysql_query($query2);
            $_POST['boleta']= $_POST['comprovante'];
            }
}

if ($_POST['opcion'] == "editar"){

    if ($_POST['DEV'] > 1){
        echo 'COD DEVOLUCION INCORRECTO';
        exit;

    }
            $fech = explode('-',$_POST['fecha']);
            $fecha_mysql = $fech[2].'-'.$fech[1].'-'.$fech[0];

    if($_POST['operador'] == 'H'){
            $query2 = "UPDATE cta SET DEV = '".$_POST['DEV']."',cod_mov='".$_POST['cod_mov2']."', tipo_comp='".$_POST['tipo_comp']."', fecha='".$fecha_mysql."',cobrador='".$_POST['cobrador']."', importe='".$_POST['importe']."',haber='".$_POST['importe']."', debe=0 ,rendicion='".$_POST['rendicion']."' WHERE cod_mov = '".$_POST['cod_mov']."' AND nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND comprovante='".$_POST['comprovante']."'";
            $aja = mysql_query($query2);
            $_POST['boleta']= $_POST['comprovante'];
    }

    if($_POST['operador'] == 'D'){
            $query2 = "UPDATE cta SET DEV = '".$_POST['DEV']."',tipo_comp='".$_POST['tipo_comp']."', fecha='".$fecha_mysql."',cobrador='".$_POST['cobrador']."', importe='".$_POST['importe']."',debe='".$_POST['importe']."', haber=0 ,rendicion='".$_POST['rendicion']."' WHERE cod_mov = '".$_POST['cod_mov']."' AND nro_doc='".$_POST['nro_doc']."' AND num_solici='".$_POST['num_solici']."' AND comprovante='".$_POST['comprovante']."'";
            $aja = mysql_query($query2);
            $_POST['boleta']= $_POST['comprovante'];
    }

    //echo '<br />'.$query2.'<br />';

}


if ( $_POST['boleta'] > 0){
    $boleta = new Cta();
    $boleta->EditaCta($_POST['boleta']);

}


if($_GET['imprimir'] == 1){

    foreach($_GET AS $campo=>$valor){
        echo $campo.' '.$valor.'<br />';

    }

    $ingreso_sql="INSERT INTO emi_par_cobranza
                 (titular,comprovante,contrato,fecha_sistema)
                 VALUES ('".$_GET['titular']."', '".$_GET['comprovante']."', '".$_GET['num_solici']."', '".date('Y-m-d')."')";

    //echo $ingreso_sql;

    $query= mysql_query($ingreso_sql);

    if($query){
       echo '<div class="mensaje1">Envio completado</<div>';
    }
    else{
       echo '<div class="mensaje2">Error</<div>';
    }


}

?>
